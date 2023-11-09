# Project Drum'N'Code
Technical task for IT company Drum'N'Code

- [Description of the technical task](https://docs.google.com/document/d/1g_6R0n4DS6rTyWS1BciNdREfJl2oA2qst04tE5c5CLo)

### Run a project with the docker
```bash
docker-compose -f docker/docker-compose.yaml up -d
```

### Execute a migration to the latest available version
```bash
./bin/console doctrine:migrations:migrate
```