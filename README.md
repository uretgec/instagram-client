# Instagram Client
All API functions are defined and write what you want, Instagram Client grab to it simple way.
You can define multiple API numbers, Client select one of them randomly.
Authorize method not automaticly, you can authorize user manually.
Access response body and header info in one CURL action.
Limit exceed control added.
All api method not tested. (Only GET methods are tested.)

## Installation
- Open Instagram/Config/application.yml
- Write Instagram Client Info (Create a new client from https://instagram.com/developer/clients/manage/)
- Run the browser or terminal to install.php file.
- YamlDumper class create ApplicationConfig.php file.
- Thats it.
- First Authorize user to Application Client (examples/authorize.php)
- Second every Application Client can be Access Token (examples/token.php)
- You are into Instagram Api. Run run run

## YamlDumper
Two method init. Yml convert to php file and backup them. 
When authorize or get access token run, update yml file and convert them.
YamlDumper class is to set many client id in application.

## Authorize Example
examples/authorize.php

## Access Token Example
examples/token.php

## Get Popular Media Example
examples/media.php


# Coming Soon
* Mapper functions will added. (Response data mapped your own mapping object)

### Changelog
* v0.1 : Release date 26.08.2015