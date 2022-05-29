# php-rabbitmq

Integração Simples de PHP com RabbitMQ.

## Requisitos
- PHP 7.4
- GIT
- Docker

## Código Fonte
1. Clone o projeto.
2. Baixe as dependências.
   ```bash
    php7.4 composer.phar install
   ```
3. Abra o seu projeto pelo VSCode.
4. Não esqueça de instalar as extensões recomendadas para melhor suporte.

## Execução
Abra o terminal e execute:
```bash
docker-compose up
```

## Acessando
Abra o navegador e acesse:
- Produtor de mensagens
    
    ```
    http://localhost:8080/producer
    ```

- Consumidor de mensagens

    ```
    http://localhost:8080/consumer
    ```
