pipeline {
  agent any
  stages {
    stage('Prepare') {
      parallel {
        stage('Prepare (Directories)') {
          steps {
            sh '''
                mkdir ./build/builddoc
                mkdir ./build/doc
                mkdir ./build/coverage
                mkdir ./build/logs
                mkdir ./build/pdepend
                mkdir ./build/phpdox
                mkdir ./build/dist
            '''
          }
        }

        stage('Prepare (Download Tools)') {
          steps {
            sh '''
                wget https://getcomposer.org/download/1.10.13/composer.phar -O composer.phar
                wget http://phpdox.de/releases/phpdox.phar -O phpdox.phar
                wget https://phpdoc.org/phpDocumentor.phar -O phpDocumentor.phar
                chmod +x ./composer.phar
                chmod +x ./phpdox.phar
                chmod +x ./phpDocumentor.phar
            '''
          }
        }
      }
    }

    stage('Install') {
      steps {
        sh '''
            php ./composer.phar install --prefer-dist --no-progress
            php ./composer.phar update --dev
        '''
      }
    }

    stage('Static-Analysis') {
      parallel {
        stage('Static-Analysis (PHPLOC)') {
          steps {
            sh './vendor/bin/phploc --count-tests --log-csv ./build/logs/phploc.csv  --log-xml ./build/logs/phploc.xml ./src ./tests'
          }
        }

        stage('Static-Analysis (PDEPEND)') {
          steps {
            sh './vendor/bin/pdepend --jdepend-xml=./build/logs/jdepend.xml --jdepend-chart=./build/pdepend/dependencies.svg --overview-pyramid=./build/pdepend/overview-pyramid.svg ./src'
          }
        }

        stage('Static Analysis (PHPMD)') {
          steps {
            sh './vendor/bin/phpmd ./src xml ./build/phpmd.xml --reportfile ./build/logs/pmd.xml --exclude ./src/entities/ || true'
          }
        }

        stage('Static-Analysis (PHPCS)') {
          steps {
            sh './vendor/bin/phpcs --report=checkstyle --report-file=./build/logs/checkstyle.xml --standard=./build/phpcsrules.xml --extensions=php --ignore=autoload.php ./src ./tests'
          }
        }

        stage('Static-Analysis (PHPCPD)') {
          steps {
            sh './vendor/bin/phpcpd --log-pmd ./build/logs/pmd-cpd.xml --exclude ./src/entities/ ./src || true'
          }
        }

      }
    }

    stage('Test') {
      steps {
        sh './vendor/bin/phpunit --configuration ./build/phpunit.xml tests'
      }
    }

    stage('Report') {
      parallel {
        stage('Report (CheckStyle)') {
          steps {
            checkstyle canComputeNew: false, defaultEncoding: '', healthy: '', pattern: 'build/logs/checkstyle.xml', unHealthy: ''
          }
        }

        stage('Report (jUnit)') {
          steps {
            junit 'build/logs/junit.xml'
          }
        }

        stage('Report (Coverage') {
          steps {
            publishHTML([allowMissing: true, alwaysLinkToLastBuild: true, keepAll: true, reportDir: 'build/coverage-html', reportFiles: 'index.html', reportName: 'HTML Report', reportTitles: ''])
          }
        }
      }
    }

    stage('Archive Artifacts') {
      steps {
        zip archive: true, dir: 'build/doc', glob: '**/*.*', zipFile: 'build/dist/doc.zip'
        zip archive: true, dir: 'src', glob: '**/*.*', zipFile: 'build/dist/src.zip'
        zip archive: true, dir: 'build/builddoc', glob: '**/*.*', zipFile: 'build/dist/builddoc.zip'
        zip archive: true, dir: 'build/coverage', glob: '**/*.*', zipFile: 'build/dist/coverage.zip'
        zip archive: true, dir: 'build/coverage-html', glob: '**/*.*', zipFile: 'build/dist/coverage-html.zip'
        zip archive: true, dir: 'build/logs', glob: '**/*.*', zipFile: 'build/dist/logs.zip'
        zip archive: true, dir: 'build/pdepend', glob: '**/*.*', zipFile: 'build/dist/pdepend.zip'
        zip archive: true, dir: 'build/phpdox', glob: '**/*.*', zipFile: 'build/dist/phpdox.zip'
      }
    }

    stage('CleanUp (After)') {
      steps {
        cleanWs()
      }
    }

  }
}