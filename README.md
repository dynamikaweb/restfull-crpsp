Restfull-crpsp 
==================


 * master link: https://crpsp.org/api
 * develop link: http://crpsp.rodrigo.dynamika.com.br:8080/api

## Exemplos de utilização

**Parametros de Entrada:**
 * `modulo` (obrigatório em view) modulo onde sera feito a consulta
 * `limit` (padrão: 1) limite de registros
 * `page` (padrão: 1) pagina de registros
 * `sort` ordenação dos registros 
 * `id` alias mais simples de  ***Modulo*Search[id]**

**Parametros de Saida:**
 * `name` Tipo da Saida
 * `message` Relatório da consulta
 * `code` 1 se existir algum dado em `data`
 * `status` codigo de estado da requisição (http code)
 * `type` class
 * `data` dados para consumo
 * `count` contagem de registros

#### Disponibilidade
sempre retorna `"data":true` enquanto à api estiver em funcionado. 

request | `name` | `code` | `status` 
:------ | ------ | ------ | -------
/api | Status | 1 | 200 
```JSON
{"name":"Status","message":"API está funcionando!","code":1,"status":200,"type":"yii\\web\\Application","data":true}
```

#### Visualização
retorna os registros, o parametro `modulo` é obrigatório se estiver faltando ou não for autorizado vai ocorrer um erro.

request | `name` | `code` | `status` 
:------ | ------ | ------ | -------
/api/view | Bad Request | 0 | 400 
/api/view?modulo=usuario | Forbiden | 0 | 403 
/api/view?modulo=noticia | View | 1 | 200 
/api/view?modulo=noticia&limit=5 | View | 1 | 200 


```JSON
{"name":"Bad Request","message":"Parâmetros obrigatórios ausentes: modulo","code":0,"status":400,"type":"yii\\web\\BadRequestHttpException"}

{"name":"Forbidden","message":"Não autorizado!","code":0,"status":403,"type":"yii\\web\\HttpException"}

{"name":"view","message":"Concluído com sucesso!","code":1,"status":200,"type":"yii\\web\\Application","data":[{"id":2356,"titulo":"Aplicativo auxilia...","slug":"aplicativo-auxilia...","tipo":null,"resumo":"O CRP SP...","fonte":"","fonte_link":"","ativo":true,"destaque":true,"credito_foto":"","credito_noticia":"","data_publicacao":"21/07/2019","youtube":"","data_criacao":"26/07/2019 22:03:45","data_modificacao":"26/07/2019 22:03:45","id_noticia_relacionada_1":null,"id_noticia_relacionada_2":null,"id_noticia_relacionada_3":null,"id_mosaico_capa_site":null,"titulo_resumido":"Aplicativo auxilia....","old_tipo":null,"old_importado":false}],"count":1}
```

#### Ordenação
por padrão os registros ficam em ordem por ID, mas é possivel escolher a ordenação com os atributos do modulo

request | ordem |
:------ | :---- | 
/api/view?modulo=noticia&limit=10 | Ordenação padrão `DESC id` |
/api/view?modulo=noticia&limit=10&sort=titulo | Titulo Crescente `ASC titulo` | 
/api/view?modulo=noticia&limit=10&sort=-titulo | Titulo Decrescente `DESC titulo` | 
/api/view?modulo=noticia&limit=10&sort=-data_publicacao | Data Decrescente `DESC data_publicacao` | 


#### Arquivos
Similar a visualização porem o parametro ID é obrigatório, e tem o retorno de um array de links no parametro `data`

**Parametros de Entrada:**
 * `size` (obrigatório, padrão é `thumb_`) tamanho das imagens (`original_`, `maior_` `media_`, `thumb_`)
 * `id` (obrigatório) registro

request | `name` | `code` | `status` 
:------ | ------ | ------ | -------
/api/files?modulo=noticia&id=555 | Files | 1 | 200 
/api/files?modulo=noticia&id=555&size=original_ | Files | 1 | 200 

```JSON
{"name":"Files","message":"Concluído com sucesso!","code":1,"status":200,"type":"yii\\web\\Application","data":["/uploads/noticia/3230/thumb_X_psrRaUva2uDgjIuMAECgQp_fcf-GHj.JPG"],"count":1}
```
