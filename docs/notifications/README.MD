### Notificações

#### Fluxo:

Quando uma transação é finalizada, o payload da notificação é persistido no banco de dados e fica represado até que seja processado pela rotina de envio de notificações

O comando `app/Core/Console/Commands/DispatchTransactionNotifications.php` é responsável pelo processamento e envio das notificações. Se o envio é realizado com sucesso, a mensagem de notificação é imediatamente removida

---

##### Sugestões de melhoria:

* Configurar CRONJOB e/ou execução via scheduller do prórprio framework utilizado
* Utilizar um recurso de fila como RabbitMQ para gerenciar as notificações
* Gerar log dos envios, bem como o conteúdo enviado
