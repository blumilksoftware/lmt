## lmt

### legnicki meetup technologiczny

![./screenshot.png](./screenshot.png)

---
## Taskfile setup
### Linux

If you don't have Task binary installed, you can install it by running command below. \
If you don't want to install to `/usr/local/bin` (dir for all users in the system) change `-b` flag value. \
Be sure that provided path is in system $PATH, that binary will be available in the terminal.
To check system paths type `$PATH` in the terminal.

```shell
sudo sh -c "$(curl --location https://taskfile.dev/install.sh)" -- -d -b /usr/local/bin v3.42.1
```
_-b sets bindir or installation directory, Defaults to ./bin_ \
_-d turns on debug logging_

Other installation methods: https://taskfile.dev/installation \
GitHub: https://github.com/go-task/task \
Taskfile releases: https://github.com/go-task/task/releases

# Task commands

---
To list all task commands just run:
```shell
task
```
### Task commands completions:

---
Add this line to `.bashrc` if you are using bash:
```
eval "$(task --completion bash)"
```
For other shells see: \
https://taskfile.dev/installation/#option-1-load-the-completions-in-your-shells-startup-config-recommended

# Project initialization

Before first use, project has to be initialized.

First, prepare `.env` file
```shell
cp .env.example .env
```

To initialize project run:
```shell
task init
```
This command will check if `.env` file exists.
Build and run containers. \
Then it will:
- install composer dependencies
- generate `APP_KEY` if not set
- run migrations with seed
- link Laravel storage
- install npm dependencies
- create test database if not exist

### Develop project

To develop project run:
```shell
task dev
```
This command will run Vite development server. \
App will be available at:
- http://lmt.blumilk.localhost- if you ran Traefik in Blumilk environment. Don't forget to update hosts file.
- http://\<container IP>:5173 - link will be displayed in console

### Running tests

You can run PHPUnit test cases

```
task test
```

### Code style check

You can run PHP-CS-Fixer:

```
task fix
```

The website should be available at [localhost:8051](localhost:8051) and [lmt.blumilk.local.env](lmt.blumilk.local.env)
if we use a Blumilk local traefik proxy.

| service             | container name                                 | default external port          |
|---------------------|------------------------------------------------|--------------------------------|
| app                 | [lmt-app-local](https://lmt.blumilk.local.env) | [8051](http://localhost:8051/) |
| mailpit (dashboard) | lmt-mailpit-local                              | [8052](http://localhost:8052/) |                  
| database            | lmt-db-local                                   | 8055                           |  


### Working with encrypted data

To encrypt/decrypt environment secrets or json files, you can use task commands: \
E.g.: `task secops:decrypt-dev-secrets`

* secops:decrypt-dev-secrets:                             Decrypt app dev secrets
* secops:encrypt-dev-secrets:                             Encrypt app dev secrets

Remember that decryption requires private key (e.g. `SOPS_AGE_DEV_SECRET_KEY` for dev environment) which should be set in `.env` file.
Encryption uses public key which is added in `.sops.yaml` file.