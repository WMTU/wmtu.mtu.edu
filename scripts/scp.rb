#!/usr/bin/env ruby
require 'net/scp'

username = ARGV[0]
password = ARGV[1]
host = ARGV[2]
src = ARGV[3]
dest = ARGV[4]

Net::SCP.upload!(host, username, src, dest, ssh: { password: password }, recursive: true) do |ch, name, sent, total|
  puts "#{name}: #{sent}/#{total}"
end
