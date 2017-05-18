#!/bin/sh

cd "$(dirname "$0")"

echo "export CONDOR_CONFIG=/private/etc/condorinstall0/etc/condor_config" >> /etc/bashrc
echo "export HOSTNAME=$(curl ifconfig.me)" >> /etc/bashrc
source /etc/bashrc

sudo dscl . create /Users/condor 
sudo dscl . create /Users/condor RealName "Condor" 
sudo dscl . create /Users/condor hint "A tribute"
sudo dscl . passwd /Users/condor bakersdozen 
sudo dscl . create /Users/condor UniqueID 42 
sudo dscl . create /Users/condor PrimaryGroupID 20 
sudo dscl . create /Users/condor UserShell /bin/bash 
sudo dscl . create /Users/condor NFSHomeDirectory /Users/condor 
sudo cp -R /System/Library/User\ Template/English.lproj /Users/condor 
sudo chown -R condor:staff /Users/condor

sudo mkdir /Users/condor/condor-local
sudo mkdir /Users/condor/condor-local/log
sudo mkdir /Users/condor/condor-local/config
sudo mkdir /Users/condor/condor-local/spool
sudo mkdir /Users/condor/condor-local/lock
sudo mkdir /Users/condor/condor-local/execute
sudo touch /Users/condor/condor-local/log/MasterLog
sudo cp ./config/condor_config.local /Users/condor/condor-local/config/condor_config.local


cd ./releaseDir
sudo ./condor_configure --install=. --install-dir=/etc/condorinstall0 --type=execute --owner=condor --local-dir=/Users/condor/condor-local --overwrite
sudo cp ../config/condor_config /private/etc/condorinstall0/etc/condor_config

cd ./sbin
echo "bakersdozen" | condor_store_cred -f /Users/condor/condor-local/lock/pool_password

sudo chmod -R 770 /Users/condor/condor-local/