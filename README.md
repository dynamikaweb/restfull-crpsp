# `CRP-SP API` Dynamika

<br>

 * master link: https://crpsp.org/api
 * develop link: http://crp-sp.rodrigo.dynamika.com.br:8080/api

## Exemplos de utilização

**Parametros de Entrada:**
 * `modulo` (obrigatório em view) modulo onde sera feito a consulta
 * `limit` (padrão: 1) limite de registros
 * `id` alias mais simples de  ***Modulo*Search[id]**

**Parametros de Saida:**
 * `name` Tipo da Saida
 * `message` Relatório da consulta
 * `code` se está disponivel `data`
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
/api/view?modulo=noticia | view | 1 | 200 
/api/view?modulo=noticia&limit=5 | view | 1 | 200 


```JSON
{"name":"Bad Request","message":"Parâmetros obrigatórios ausentes: modulo","code":0,"status":400,"type":"yii\\web\\BadRequestHttpException"}

{"name":"Forbidden","message":"Não autorizado!","code":0,"status":403,"type":"yii\\web\\HttpException"}

{"name":"view","message":"Concluído com sucesso!","code":1,"status":200,"type":"yii\\web\\Application","data":[{"id":2356,"titulo":"Aplicativo auxilia fiscais da Comissão de Orientação e Fiscalização do CRP SP","slug":"aplicativo-auxilia-fiscais-da-comissao-de-orientacao-e-fiscalizacao-do-crp-sp","tipo":null,"resumo":"O CRP SP inova e apresenta o aplicativo Sistema de Fiscalização CRP SP, que auxilia as/os fiscais da Comissão de Orientação e Fiscalização (COF) por meio da tecnologia.","descricao":"<p>O Conselho Regional de Psicologia de S&atilde;o Paulo - 6&ordf; Regi&atilde;o inova e apresenta o aplicativo Sistema de Fiscaliza&ccedil;&atilde;o CRP SP, que auxilia as/os fiscais da Comiss&atilde;o de Orienta&ccedil;&atilde;o e Fiscaliza&ccedil;&atilde;o (COF) por meio da tecnologia. Com o lan&ccedil;amento da funcionalidade, as profissionais passaram a trabalhar com tablets, facilitando o dia a dia das trabalhadoras e garantindo a seguran&ccedil;a das informa&ccedil;&otilde;es.<br />O CRP SP tem a finalidade de orientar, disciplinar e fiscalizar o exerc&iacute;cio da profiss&atilde;o de psic&oacute;logo, de acordo com o estabelecido na Lei Federal n&deg; 5.766, de 20 de dezembro de 1971.</p>\r\n<p>Existem 23 Conselhos Regionais em todo o Pa&iacute;s, distribu&iacute;dos por Estados ou regi&otilde;es. O CRP SP mant&eacute;m uma sede na capital e nove subsedes no interior: Assis, Baixada Santista e Vale do Ribeira, Bauru, Campinas, Grande ABC, Ribeir&atilde;o Preto, S&atilde;o Jos&eacute; do Rio Preto, Sorocaba e Vale do Para&iacute;ba e Litoral Norte.</p>\r\n<p>As metas e formas de trabalho do Conselho Federal (CFP) e dos Conselhos Regionais (CRPs) s&atilde;o pautadas pelas delibera&ccedil;&otilde;es do Congresso Nacional de Psicologia, realizados a cada tr&ecirc;s anos, quando s&atilde;o aprovadas teses sobre a estrutura funcional dos Conselhos e os princ&iacute;pios que norteiam suas a&ccedil;&otilde;es quanto aos exerc&iacute;cios, &agrave; forma&ccedil;&atilde;o e &agrave; &eacute;tica profissional.</p>\r\n<p>Comiss&otilde;es <br />S&atilde;o respons&aacute;veis pelas atividades legalmente atribu&iacute;das ao CRP, quais sejam, orientar, fiscalizar e disciplinar o exerc&iacute;cio profissional. S&atilde;o elas: Comiss&atilde;o de Orienta&ccedil;&atilde;o e &Eacute;tica (COE), Comiss&atilde;o de Orienta&ccedil;&atilde;o e Fiscaliza&ccedil;&atilde;o (COF) e Comiss&atilde;o de An&aacute;lise para Concess&atilde;o de Registro de Especialista.</p>","fonte":"","fonte_link":"","ativo":true,"destaque":true,"credito_foto":"","credito_noticia":"","data_publicacao":"21/07/2019","youtube":"","data_criacao":"26/07/2019 22:03:45","data_modificacao":"26/07/2019 22:03:45","id_noticia_relacionada_1":null,"id_noticia_relacionada_2":null,"id_noticia_relacionada_3":null,"id_mosaico_capa_site":null,"titulo_resumido":"Aplicativo auxilia fiscais da Comissão de Orientação e Fiscalização do CRP SP","old_tipo":null,"old_importado":false}],"count":1}
```
