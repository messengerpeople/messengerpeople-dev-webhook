# Webhook Examples

Simple webhooks, simple documentation, simple examples.
Here you'll find example webhooks for different programming languages. They are not pretty, but they do the job. 

We strongly suggest to keep webhooks simple and fast and handle processing logic async. This webhook contains an example message for testing. You can navigate to https://app.messengerpeople.dev/webhook-calls to see all the webhooks we tried to deliver to your 500-server :-P 

DO:

Store the incoming message in a messagequeue or database and process it asynchronously in a different worker.

DON'T:

Parse the message, do many DB Queries, or any blocking external requests. We have a very low timeout setting (2 seconds), so keep your webhook fast.

