# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|
  
  # Box Settings
  config.vm.box = "generic/ubuntu2004"

  # Provider Settings
  config.vm.provider "virtualbox" do |vb|
    vb.memory = 2048
    vb.cpus = 4
  end

  # Network Settings
  config.vm.network "forwarded_port", guest: 80, host: 8080
  #config.vm.network "forwarded_port", guest: 80, host: 8080, host_ip: "127.0.0.1"
  #config.vm.network "forwarded_port", guest: 3306, host: 3306
  # config.vm.network "private_network", ip: "192.168.33.10"

  # Folder Settings
  config.vm.synced_folder ".", "/var/www/html", :mount_options => ["dmode=777", "fmode=666"]
  
  config.vm.provision "shell", path: "./config/bootstrap.sh"
end