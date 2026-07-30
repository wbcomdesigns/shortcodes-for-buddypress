'use strict';
module.exports = function (grunt) {
    // Load all grunt tasks automatically
    require('load-grunt-tasks')(grunt);

    // Time how long tasks take for optimization
    require('time-grunt')(grunt);

    // Project configuration
    grunt.initConfig({
        pkg: grunt.file.readJSON('package.json'),

        // Clean tasks - remove generated files before rebuild
        clean: {
            css: ['public/css/min/', 'assets/css/min/'],
            js: ['public/js/min/', 'assets/js/min/'],
            rtl: ['public/css/rtl/', 'assets/css/rtl/'],
            build: ['build/'],
            temp: ['temp/']
        },

        // Copy files for build
        copy: {
            build: {
                files: [{
                    expand: true,
                    src: [
                        '**',
                        '!node_modules/**',
                        '!build/**',
                        '!temp/**',
                        // Lowercase too: minimatch is case-sensitive, so
                        // '!Gruntfile.js' alone shipped gruntfile.js.
                        '!Gruntfile.js',
                        '!gruntfile.js',
                        '!package.json',
                        '!package-lock.json',
                        '!.git/**',
                        '!.gitignore',
                        // '!*.md' matches root level only, which shipped
                        // audit/*.md and docs/*.md to customers.
                        '!*.md',
                        '!**/*.md',
                        // Internal QA baselines and feature audits.
                        '!audit/**',
                        '!.DS_Store',
                        '!**/.DS_Store',
                        '!*.zip',
                        '!tests/**',
                        '!bin/**',
                        '!.editorconfig',
                        '!.eslintrc',
                        '!.jshintrc',
                        '!composer.json',
                        '!composer.lock',
                        '!phpcs.xml',
                        '!phpunit.xml',
                        '!phpunit.xml.dist',
                        '!phpstan.neon',
                        '!phpstan-baseline.neon',
                        '!phpstan-bootstrap.php',
                        '!vendor/**',
                        '!.github/**',
                        '!.phpunit.result.cache',
                        // Internal contract-audit suppressions, same category
                        // as audit/**.
                        '!.contract-audit-baseline.json',
                        // '!**/*.md' strips the files but leaves the empty
                        // docs/ directory entry behind in the archive.
                        '!docs/**',
                        // WP.org readme screenshots belong in the SVN assets/
                        // directory, not in the plugin every user installs.
                        // These six are ~900KB of dead weight on every site.
                        '!screenshot-*.png',
                    ],
                    dest: 'build/<%= pkg.name %>/'
                }]
            }
        },

        // Task for checking text domain
        checktextdomain: {
            options: {
                text_domain: ['shortcodes-for-buddypress'],
                keywords: [
                    '__:1,2d',
                    '_e:1,2d',
                    '_x:1,2c,3d',
                    'esc_html__:1,2d',
                    'esc_html_e:1,2d',
                    'esc_html_x:1,2c,3d',
                    'esc_attr__:1,2d',
                    'esc_attr_e:1,2d',
                    'esc_attr_x:1,2c,3d',
                    '_ex:1,2c,3d',
                    '_n:1,2,4d',
                    '_nx:1,2,4c,5d',
                    '_n_noop:1,2,3d',
                    '_nx_noop:1,2,3c,4d'
                ],
            },
            files: {
                src: [
                    '*.php',
                    '**/*.php',
                    '!node_modules/**',
                    '!build/**',
                    '!tests/**',
                    '!vendor/**'
                ],
                expand: true
            },
        },

        // Task for CSS minification with source maps
        cssmin: {
            options: {
                keepSpecialComments: 0,
                sourceMap: true,
                rebase: false
            },
            public: {
                files: [{
                    expand: true,
                    cwd: 'public/css/',
                    src: ['*.css', '!*.min.css', '!vendor/*.css'],
                    dest: 'public/css/min',
                    ext: '.min.css'
                }]
            },
            admin: {
                files: [{
                    expand: true,
                    cwd: 'assets/css/',
                    src: ['*.css', '!*.min.css', '!vendor/*.css'],
                    dest: 'assets/css/min/',
                    ext: '.min.css'
                }]
            }
        },

        // Task for JavaScript minification with better options
        uglify: {
            options: {
                sourceMap: true,
                sourceMapIncludeSources: true,
                mangle: {
                    reserved: ['jQuery', 'Backbone', '_', 'wp', 'bp']
                },
                compress: {
                    drop_console: false,
                    drop_debugger: true
                },
                output: {
                    comments: false
                }
            },
            public: {
                files: [{
                    expand: true,
                    cwd: 'public/js/',
                    src: ['*.js', '!*.min.js', '!vendor/*.js'],
                    dest: 'public/js/min/',
                    ext: '.min.js'
                }]
            },
            admin: {
                files: [{
                    expand: true,
                    cwd: 'assets/js/',
                    src: ['*.js', '!*.min.js', '!vendor/*.js'],
                    dest: 'assets/js/min/',
                    ext: '.min.js'
                }]
            }
        },

        // JavaScript linting
        jshint: {
            options: {
                jshintrc: true,
                reporter: require('jshint-stylish')
            },
            all: [
                'Gruntfile.js',
                'public/js/*.js',
                'assets/js/*.js',
                '!public/js/*.min.js',
                '!assets/js/*.min.js',
                '!public/js/vendor/**',
                '!assets/js/vendor/**'
            ]
        },

        // Task for generating RTL CSS
        rtlcss: {
            options: {
                map: false,
                opts: {
                    clean: true,
                    processUrls: false,
                    stringMap: [{
                        name: 'left-right',
                        priority: 100,
                        search: ['left', 'Left', 'LEFT'],
                        replace: ['right', 'Right', 'RIGHT']
                    }]
                },
                saveUnmodified: false
            },
            public: {
                files: [{
                    expand: true,
                    cwd: 'public/css/min/',
                    src: ['*.min.css', '!*.rtl.css'],
                    dest: 'public/css/rtl/',
                    ext: '.rtl.css'
                }]
            },
            admin: {
                files: [{
                    expand: true,
                    cwd: 'assets/css/min/',
                    src: ['*.min.css', '!*.rtl.css'],
                    dest: 'assets/css/rtl/',
                    ext: '.rtl.css'
                }]
            }
        },

        // Generate POT file for translations
        makepot: {
            target: {
                options: {
                    domainPath: '/languages',
                    exclude: ['node_modules/.*', 'build/.*', 'tests/.*'],
                    mainFile: 'shortcodes-for-buddypress.php',
                    potFilename: 'shortcodes-for-buddypress.pot',
                    potHeaders: {
                        poedit: true,
                        'x-poedit-keywordslist': true,
                        'report-msgid-bugs-to': 'https://github.com/wbcomdesigns/shortcodes-for-buddypress/issues',
                        'language-team': 'Wbcom Designs <admin@wbcomdesigns.com>'
                    },
                    type: 'wp-plugin',
                    updateTimestamp: true
                }
            }
        },

        // Shell commands
        shell: {
            makepot: {
                command: 'wp i18n make-pot . languages/shortcodes-for-buddypress.pot' +
                    ' --exclude=node_modules,build,tests,audit,docs' +
                    ' --headers=\'{"Report-Msgid-Bugs-To":"https://github.com/wbcomdesigns/shortcodes-for-buddypress/issues",' +
                    '"Last-Translator":"Wbcom Designs <admin@wbcomdesigns.com>",' +
                    '"Language-Team":"Wbcom Designs <admin@wbcomdesigns.com>"}\''
            },
            phpcs: {
                command: 'phpcs --standard=WordPress --extensions=php --ignore=*/vendor/*,*/node_modules/*,*/build/* .'
            },
            phpcbf: {
                command: 'phpcbf --standard=WordPress --extensions=php --ignore=*/vendor/*,*/node_modules/*,*/build/* .'
            }
        },

        // Create plugin zip file
        compress: {
            main: {
                options: {
                    archive: 'shortcodes-for-buddypress-v<%= pkg.version %>.zip',
                    mode: 'zip'
                },
                files: [{
                    expand: true,
                    cwd: 'build/',
                    src: ['**'],
                    dest: '/'
                }]
            }
        },

        // Watch for file changes
        watch: {
            options: {
                livereload: true,
                spawn: false
            },
            css: {
                files: ['public/css/*.css', '!public/css/*.min.css'],
                tasks: ['cssmin:public', 'rtlcss:public']
            },
            adminCss: {
                files: ['assets/css/*.css', '!assets/css/*.min.css'],
                tasks: ['cssmin:admin', 'rtlcss:admin']
            },
            js: {
                files: ['public/js/*.js', '!public/js/*.min.js'],
                tasks: ['jshint', 'uglify:public']
            },
            adminJs: {
                files: ['assets/js/*.js', '!assets/js/*.min.js'],
                tasks: ['jshint', 'uglify:admin']
            },
            php: {
                files: ['**/*.php', '!node_modules/**', '!build/**'],
                tasks: ['checktextdomain']
            },
            pot: {
                files: ['**/*.php', '!node_modules/**', '!build/**'],
                tasks: ['makepot']
            }
        },

        // Concurrent tasks for faster builds
        concurrent: {
            options: {
                logConcurrentOutput: true
            },
            css: ['cssmin:public', 'cssmin:admin'],
            js: ['uglify:public', 'uglify:admin'],
            rtl: ['rtlcss:public', 'rtlcss:admin']
        }
    });

    // Register tasks
    grunt.registerTask('default', 'Default development task', function() {
        grunt.log.writeln('Running default development tasks...');
        grunt.task.run([
            'clean:css',
            'clean:js',
            'concurrent:css',
            'concurrent:js',
            'concurrent:rtl',
            'checktextdomain'
        ]);
    });

    // Development task with watch
    grunt.registerTask('dev', 'Development mode with watch', [
        'default',
        'watch'
    ]);

    // Build task for production
    grunt.registerTask('build', 'Create production build', [
        'clean',
        'checktextdomain',
        'concurrent:css',
        'concurrent:js',
        'concurrent:rtl',
        // shell:makepot (wp i18n make-pot), not the grunt-wp-i18n `makepot`
        // task. The two generators disagree, and grunt-wp-i18n 1.0.3 is what
        // produced the stale POT that shipped 714 references to deleted files.
        'shell:makepot',
        'copy:build',
        'compress',
        'clean:build'
    ]);

    // CSS only task
    grunt.registerTask('css', 'Process CSS files only', [
        'clean:css',
        'concurrent:css',
        'concurrent:rtl'
    ]);

    // JS only task
    grunt.registerTask('js', 'Process JavaScript files only', [
        'jshint',
        'clean:js',
        'concurrent:js'
    ]);

    // Internationalization task
    grunt.registerTask('i18n', 'Generate translation files', [
        'checktextdomain',
        'shell:makepot'
    ]);

    // Code quality task
    grunt.registerTask('quality', 'Check code quality', [
        'jshint',
        'checktextdomain',
        'shell:phpcs'
    ]);

    // Fix code style
    grunt.registerTask('fix', 'Fix code style issues', [
        'shell:phpcbf'
    ]);

    // Quick minification without cleaning
    grunt.registerTask('minify', 'Quick minification', [
        'concurrent:css',
        'concurrent:js'
    ]);
};