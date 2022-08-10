#!/bin/sh

apt-get update -yqq && apt-get install -yqq \
curl \
dnsutils \
gdb \
git \
htop \
iputils-ping \
ltrace \
make \
procps \
strace \
sudo \
sysstat \
unzip \
vim \
wget \
net-tools \
supervisor \
;
apt-get install -y --no-install-recommends python3-pip python3-setuptools python3-wheel
pip3 install supervisor-stdout
