# Teste OTOCrm

### Versões das aplicações utilizadas:
Apache: ``2.4.47``
|
PHP: ``7.4.16-NTS``
|
MySQL: ``5.7.24``
|
Laravel: ``8.75``

### Pergunta 1: Criação do banco de dados:

Os dados de acesso ao banco de dados ficaram salvos no .env:
````dotenv
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=oto_crm
DB_USERNAME=root
DB_PASSWORD=root
````


CREATE TABLE:
```sql
CREATE TABLE `orders`
(
    `id`          bigint(20) unsigned NOT NULL AUTO_INCREMENT,
    `order_id`    bigint(20) unsigned NOT NULL,
    `order_date`  datetime    NOT NULL,
    `product_sku` varchar(64) NOT NULL,
    `size`        varchar(16) NOT NULL,
    `color`       varchar(32) NOT NULL,
    `quantity`    int(10) unsigned NOT NULL,
    `price`       decimal(10, 2) unsigned NOT NULL,
    PRIMARY KEY (`id`),
    KEY           `order_id` (`order_id`),
    KEY           `order_date` (`order_date`),
    KEY           `product_sku` (`product_sku`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1
```

Acima se encontra o ``SHOW CREATE TABLE orders`` utilizado no teste.

<p style="text-align: justify">
O arquivo enviado contendo os dados do SQL, foram encontradas duas inconsistências:

1. Alguns itens encontram-se com a data ``2021-02-29`` o que ocasiona erro de integridade ao banco de dados, estes dados
   foram retirados/pulados durante a inserção no banco de dados.
2. Alguns itens apresentaram erro de UTF8, os itens de cor ``CAFE``, estes foram corrigidos e inseridos novamente na
   lista para integrar o teste.
3. O item 1 não foi inserido, pois poderia afetar o total de determinadas datas, afinal 2021 não possui 29 de fevereiro.
</p>

### Pergunta 2: Criação da Classe
<p style="text-align: justify">
A classe foi criada seguindo a premissa de ser um serviço, ou seja, poderia ser utilizada por diversas classes sem
necessidade de depender diretamente da porta de entrada, também poderia ser compreendida como uma entidade dependendo do
contexto que a equipe utiliza na sua estrutura.
</p>

### Pergunta 3: Criação do ENDPOINT de consulta das estatisticas
<p style="text-align: justify">
Foi criado o endpoint utilizando as funções já disponibizadas anteriormente na criação da Classe de Serviço.
</p>

### Pergunta 4: Refatoramento da função getOrdersByDate
<p style="text-align: justify">
Fiz de dois jeitos, um utilizando a função map da classe <strong>COLLECTION</strong> do Laravel, que permite fazer diversas coisas,
inclusive foi bastante utilizada na criação da classe assim melhorando o entendimento e impedindo repetição de código.
E a outra maneira foi o bom e velho <strong>FOREACH</strong>, que ficou em duas linhas e da pra entender o que se está fazendo de uma maneir bem simples.
</p>

Dentro do projeto está um arquivo do postman para testar facilmente a parte da API.
``Orders.postman_collection.json``
