# Endpoints

Observação: O prefixo de acesso é `/v1`. Por padrão a aplicação irá rodar na porta `9000`, portanto o endereço de consumo dos endpoints será: `http://localhost:9000/v1`

## Realizar transferências entre usuários

`/transactions` 

`POST`

### Request

**Exemplo de payload:**

```
{
    "value" : 50.00,
    "payer" : 2,
    "payee" : 25
}
```

sendo,

`value`: É o valor da transação. Seu tipo é `decimal` e é de preenchimento obrigatório

`payer`: É o pagador. Seu tipo é `integer` e é de preenchimento obrigatório

`payee`: É o destinatário do valor. Seu tipo é `integer` e é de preenchimento obrigatório

---

**Exemplo de requisição via cURL:**

```
curl -X POST \
  http://localhost:9000/v1/transactions \
  -H 'Content-Type: application/json' \
  -d '{
    "value" : 50.00,
    "payer" : 2,
    "payee" : 25
}'
```

### Response

* Em caso de sucesso

```
{
    "message": "Transação realizada com sucesso!",
    "data": [
        "transaction_id": 1
    ]
}
```

* Em caso de tentativa de envio de valores por usuário lojistas

```
{
    "message": "Somente usuários comuns podem realizar transferências.",
    "data": []
}
```

* Em caso de insuficiência de saldo

```
{
    "message": "Saldo insuficiente para realizar a transação.",
    "data": []
}
```

---

###### Obs¹.: Esses são apenas alguns exemplos. Existe uma estrutura padrão de resposta, devendo apenas variar o seu conteúdo

###### Obs¹.: O código de status estará sempre presente no cabeçalho da resposta de acordo com a ocorrência

---

## Realizar rollback de um transação

`/transactions/reverse`

`POST`

### Request

**Exemplo de payload:**

```
{
    "transaction" : 1
}
```

sendo,

`transaction`: É o identificador da transação. Seu tipo é `integer` e é de preenchimento obrigatório

---

**Exemplo de requisição via cURL:**

```
curl -X POST \
  http://localhost:9000/v1/transactions/reverse \
  -H 'Content-Type: application/json' \
  -d '{
    "transaction" : 1
}'
```

---

### Response

* Em caso de sucesso

```
{
    "message": "Operação realizada com sucesso!",
    "data": []
}
```
