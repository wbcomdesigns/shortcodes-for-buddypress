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
            css: ['public/css/min/', 'admin/css/min/', 'admin/wbcom/assets/css/min/'],
            js: ['public/js/min/', 'admin/js/min/', 'admin/wbcom/assets/js/min/'],
            rtl: ['public/css/rtl/', 'admin/css/rtl/', 'admin/wbcom/assets/css/rtl/'],
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
                        '!Gruntfile.js',
                        '!package.json',
                        '!package-lock.json',
                        '!.git/**',
                        '!.gitignore',
                        '!*.md',
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
                        '!phpunit.xml'
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
                    cwd: 'admin/css/',
                    src: ['*.css', '!*.min.css', '!vendor/*.css'],
                    dest: 'admin/css/min/',
                    ext: '.min.css'
                }]
            },
            wbcom: {
                files: [{
                    expand: true,
                    cwd: 'admin/wbcom/assets/css/',
                    src: ['*.css', '!*.min.css', '!vendor/*.css'],
                    dest: 'admin/wbcom/assets/css/min/',
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
                    cwd: 'admin/js/',
                    src: ['*.js', '!*.min.js', '!vendor/*.js'],
                    dest: 'admin/js/min/',
                    ext: '.min.js'
                }]
            },
            wbcom: {
                files: [{
                    expand: true,
                    cwd: 'admin/wbcom/assets/js',
                    src: ['*.js', '!*.min.js', '!vendor/*.js'],
                    dest: 'admin/wbcom/assets/js/min/',
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
                'admin/js/*.js',
                '!public/js/*.min.js',
                '!admin/js/*.min.js',
                '!public/js/vendor/**',
                '!admin/js/vendor/**'
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
                    cwd: 'admin/css/min/',
                    src: ['*.min.css', '!*.rtl.css'],
                    dest: 'admin/css/rtl/',
                    ext: '.rtl.css'
                }]
            },
            wbcom: {
                files: [{
                    expand: true,
                    cwd: 'admin/wbcom/assets/css/min/',
                    src: ['*.min.css', '!*.rtl.css'],
                    dest: 'admin/wbcom/assets/css/rtl/',
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
                command: 'wp i18n make-pot . languages/shortcodes-for-buddypress.pot --exclude=node_modules,build,tests'
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
                files: ['admin/css/*.css', '!admin/css/*.min.css'],
                tasks: ['cssmin:admin', 'rtlcss:admin']
            },
            wbcomCss: {
                files: ['admin/wbcom/assets/css/*.css', '!admin/wbcom/assets/css/*.min.css'],
                tasks: ['cssmin:wbcom', 'rtlcss:wbcom']
            },
            js: {
                files: ['public/js/*.js', '!public/js/*.min.js'],
                tasks: ['jshint', 'uglify:public']
            },
            adminJs: {
                files: ['admin/js/*.js', '!admin/js/*.min.js'],
                tasks: ['jshint', 'uglify:admin']
            },
            wbcomJs: {
                files: ['admin/wbcom/assets/js/*.js', '!admin/wbcom/assets/js/*.min.js'],
                tasks: ['uglify:wbcom']
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
            css: ['cssmin:public', 'cssmin:admin', 'cssmin:wbcom'],
            js: ['uglify:public', 'uglify:admin', 'uglify:wbcom'],
            rtl: ['rtlcss:public', 'rtlcss:admin', 'rtlcss:wbcom']
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
        'makepot',
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
        'makepot'
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