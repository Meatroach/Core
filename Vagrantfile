# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure(2) do |config|
  config.vm.box = "ubuntu/trusty64"

  config.vm.synced_folder ".", "/var/www/opentribes", :nfs => true

  config.vm.hostname = "opentribes"

  config.vm.provider "virtualbox" do |vb|
    # vb settings
    vb.name = "Opentribes VM"

    # vb customizations
    vb.customize ['modifyvm', :id, '--cpus', 1]
    vb.customize ['modifyvm', :id, '--memory', 1024]
    vb.customize ["modifyvm", :id, "--natdnshostresolver1", "on"]
  end

  config.vm.network :private_network, :ip => '192.156.68.112'

  # shell provisioner which installs all mandatory puppet modules
  config.vm.provision :shell, path: "vagrant/puppet.sh"

  # puppet provisioner
  config.vm.provision :puppet do |puppet|
    puppet.manifests_path = "vagrant/manifests"
    puppet.manifest_file  = 'opentribes.pp'
    puppet.options        = ["--verbose"]
  end

  # provisioner that
  config.vm.provision :shell, path: "vagrant/composer.sh"
end
