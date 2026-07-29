#!/usr/bin/env bash
#
# Local CI runner for shortcodes-for-buddypress.
#
# Runs the same blocking gates as .github/workflows/ci.yml so a developer can
# verify before pushing. This matters more than usual here: GitHub Actions is
# currently disabled at the repository level, so this script is the only place
# the gates actually run.
#
#   bin/local-ci.sh                 lint + WPCS + PHPStan + PHPUnit
#   bin/local-ci.sh --bootstrap     one-time composer install + WP test suite
#   bin/local-ci.sh --no-unit       skip PHPUnit (no database needed)
#   bin/local-ci.sh --only-unit     PHPUnit alone
#
# Exit code is 0 only when every gate that ran passed, matching CI.

set -uo pipefail

PLUGIN_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")/.." && pwd)"
cd "$PLUGIN_DIR" || exit 1

# Where the WordPress test library lives. Override by exporting before running.
: "${WP_TESTS_DIR:=$HOME/.wp-tests/wordpress-tests-lib}"
: "${WP_CORE_DIR:=$HOME/.wp-tests/wordpress}"
export WP_TESTS_DIR WP_CORE_DIR

# Local by Flywheel ships its own MySQL on a socket rather than a TCP port.
LOCAL_MYSQL_BIN="$HOME/Library/Application Support/Local/lightning-services/mysql-8.0.35+4/bin/darwin-arm64/bin"
: "${BPSP_DB_NAME:=bpsp_tests}"
: "${BPSP_DB_USER:=root}"
: "${BPSP_DB_PASS:=root}"

RUN_LINT=1; RUN_CS=1; RUN_STAN=1; RUN_UNIT=1; BOOTSTRAP=0

for arg in "$@"; do
	case "$arg" in
		--bootstrap) BOOTSTRAP=1 ;;
		--no-lint)   RUN_LINT=0 ;;
		--no-cs)     RUN_CS=0 ;;
		--no-stan)   RUN_STAN=0 ;;
		--no-unit)   RUN_UNIT=0 ;;
		--only-unit) RUN_LINT=0; RUN_CS=0; RUN_STAN=0 ;;
		-h|--help)   sed -n '2,20p' "$0" | sed 's/^# \{0,1\}//'; exit 0 ;;
		*) echo "Unknown option: $arg (try --help)"; exit 2 ;;
	esac
done

BOLD=$'\033[1m'; GREEN=$'\033[0;32m'; RED=$'\033[0;31m'; DIM=$'\033[2m'; OFF=$'\033[0m'
FAILED=()

step() { printf '%s\n' "${BOLD}── $1 ──${OFF}"; }
pass() { printf '%s\n\n' "${GREEN}PASS${OFF} $1"; }
fail() { printf '%s\n\n' "${RED}FAIL${OFF} $1"; FAILED+=("$1"); }

find_mysql_socket() {
	local sock
	sock=$(ls "$HOME/Library/Application Support/Local/run/"*/mysql/mysqld.sock 2>/dev/null | head -1)
	printf '%s' "$sock"
}

if [ "$BOOTSTRAP" -eq 1 ]; then
	step "Bootstrap"
	composer install --no-interaction --prefer-dist || { echo "composer install failed"; exit 1; }

	SOCK="$(find_mysql_socket)"
	if [ -z "$SOCK" ]; then
		echo "${RED}Could not find a Local by Flywheel MySQL socket.${OFF}"
		echo "Start the site in Local, or export WP_TESTS_DIR against your own WordPress test suite."
		exit 1
	fi
	export PATH="$LOCAL_MYSQL_BIN:$PATH"
	mysql --socket="$SOCK" -u"$BPSP_DB_USER" -p"$BPSP_DB_PASS" \
		-e "CREATE DATABASE IF NOT EXISTS ${BPSP_DB_NAME};" 2>/dev/null

	bash bin/install-wp-tests.sh "$BPSP_DB_NAME" "$BPSP_DB_USER" "$BPSP_DB_PASS" "localhost:$SOCK" 6.5 true

	# The shortcodes are meaningless without BuddyPress, so the suite needs it
	# beside the plugin where tests/bootstrap.php looks.
	if [ ! -d "$WP_CORE_DIR/wp-content/plugins/buddypress" ] && [ -d "../buddypress" ]; then
		mkdir -p "$WP_CORE_DIR/wp-content/plugins"
		cp -R ../buddypress "$WP_CORE_DIR/wp-content/plugins/buddypress"
		echo "Copied BuddyPress into the test suite."
	fi
	pass "bootstrap"
fi

if [ ! -d vendor ]; then
	echo "${RED}vendor/ is missing. Run: bin/local-ci.sh --bootstrap${OFF}"
	exit 1
fi

if [ "$RUN_LINT" -eq 1 ]; then
	step "PHP Lint"
	if find . -name '*.php' -not -path './vendor/*' -not -path './node_modules/*' -print0 \
		| xargs -0 -n1 -P4 php -l > /dev/null 2>&1; then
		pass "php -l across the tree"
	else
		find . -name '*.php' -not -path './vendor/*' -not -path './node_modules/*' -print0 \
			| xargs -0 -n1 php -l 2>&1 | grep -v '^No syntax errors' | head -20
		fail "PHP lint"
	fi
fi

if [ "$RUN_CS" -eq 1 ]; then
	step "WordPress Coding Standards"
	# Errors block; warnings are advisory, matching the CI job.
	if vendor/bin/phpcs --error-severity=1 --warning-severity=0 --report=summary > /dev/null 2>&1; then
		pass "0 errors"
		WARNINGS=$(vendor/bin/phpcs --error-severity=0 --warning-severity=1 --report=summary 2>/dev/null \
			| grep -oE '[0-9]+ WARNING' | head -1)
		[ -n "${WARNINGS:-}" ] && printf '%s\n\n' "${DIM}   advisory: ${WARNINGS}${OFF}"
	else
		vendor/bin/phpcs --error-severity=1 --warning-severity=0 --report=full 2>&1 | tail -30
		fail "WPCS"
	fi
fi

if [ "$RUN_STAN" -eq 1 ]; then
	step "PHPStan (level 5)"
	STAN_OUT=$(vendor/bin/phpstan analyse --no-progress --memory-limit=2G 2>&1)
	# Match on the result line rather than the exit code so the "PHPStan 2.x is
	# available" upgrade notice cannot be mistaken for a failure.
	if printf '%s' "$STAN_OUT" | grep -qE '\[OK\] No errors|Found 0 errors'; then
		pass "no new errors above the baseline"
	else
		printf '%s\n' "$STAN_OUT" | tail -30
		fail "PHPStan"
	fi
fi

if [ "$RUN_UNIT" -eq 1 ]; then
	step "PHPUnit (functional)"
	if [ ! -f "$WP_TESTS_DIR/includes/functions.php" ]; then
		echo "${RED}WordPress test suite not installed at ${WP_TESTS_DIR}${OFF}"
		echo "Run: bin/local-ci.sh --bootstrap"
		fail "PHPUnit (not bootstrapped)"
	else
		UNIT_OUT=$(vendor/bin/phpunit --testsuite functional 2>&1)
		if printf '%s' "$UNIT_OUT" | grep -qE '^OK \('; then
			pass "$(printf '%s' "$UNIT_OUT" | grep -E '^OK \(' | head -1)"
		else
			printf '%s\n' "$UNIT_OUT" | tail -30
			fail "PHPUnit"
		fi
	fi
fi

printf '%s\n' "${BOLD}────────────────────────────────${OFF}"
if [ ${#FAILED[@]} -eq 0 ]; then
	printf '%s\n' "${GREEN}All blocking gates passed. Safe to push.${OFF}"
	exit 0
fi
printf '%s\n' "${RED}Blocking gates failed: ${FAILED[*]}${OFF}"
exit 1
