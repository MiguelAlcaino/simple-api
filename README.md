# Simple Tweet API

This is a simple REST API that allows you to create, read, update and delete tweets. It is built with PHP, Symfony and PostgreSQL.

## Remote Server
There is a server already running on render.com that is running this API. You can access it  at : https://simple-api-te74.onrender.com

## Endpoints
The documentation about the endpoints can be found here: https://www.notion.so/Simple-tweets-api-def3a2e043db4f11ab3ef44e6cec7d6f?pvs=4

## Local Installation
To run this API locally you need Docker and Docker Compose installed on your machine. After that, you can run the following commands:

 - To clone the repository on your machine run (you need to have git installed and configured to use SSH with GitHub) :
```bash
git clone git@github.com:MiguelAlcaino/simple-api.git
```
 - To build the environment and run the system, run:
```bash
make build
```
 - If this is the first time installing this API, you need to create the database by running:
```bash
make db-create
```
- To update the database to its latest version, run:
```bash
make db-update
```

## Remove the installation
To remove the installation and the database, run:
```bash
make destroy
```
