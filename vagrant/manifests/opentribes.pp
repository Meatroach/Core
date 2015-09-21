# apt setup
# installs all mandatory packages
class { 'apt': }

$internalPackages = ['git', 'vim', 'bash-completion', 'build-essential', 'wget', 'curl']

package { $internalPackages:
  ensure => installed,
}

# php setup
class { 'php':
  service => 'apache',
}

php::ini { 'php.ini customizations':
  value   => [
    'date.timezone = "UTC"',
    'display_errors = On',
    'error_reporting = -1',
  ],
  notify  => Service['apache'],
  require => Class['php'],
}

php::module { 'gd': }
php::module { 'xdebug': }
php::module { 'cli': }
php::module { 'mysql': }
php::module { 'curl': }
php::module { 'intl': }
php::module { 'mcrypt': }

class { '::composer':
  command_name => 'composer',
  auto_update  => true,
  require      => Package['php5', 'curl'],
  target_dir   => '/usr/local/bin',
}

# apache setup
class { 'apache': }

$host_name = 'opentribes.dev'

apache::module { 'rewrite': }
apache::vhost { $host_name:
  server_name              => $host_name,
  port                     => 80,
  docroot                  => '/var/www/opentribes/web/',
  directory_allow_override => 'All',
  env_variables            => [
    'env develop'
  ]
}

# mysql database
class { 'mysql::server':
  override_options => { 'root_password' => '', },
}

mysql::db { 'ot_test':
  user     => 'test',
  password => 'test',
  host     => 'localhost',
  grant    => ['ALL'],
}

mysql::db { 'ot_dev':
  user     => 'dev',
  password => 'dev',
  host     => 'localhost',
  grant    => ['ALL'],
}
