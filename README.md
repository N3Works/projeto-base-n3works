#Instruções
Apois dar o clone do projeto:

1º Verificar se já existe o docker instalado na maquina.
2º Ajustar o docker-compose.yml colocando o nome das containers de acordo com o projeto, e ajustando a imagem que será utilizada.
3º Executar o comando de "docker-compose up -d"
4º Caso esteja tudo de acordo e as containers estejam em pé (verificar com "docker ps") vá para o 5º passo.
5º Executar o comando "docker exec -it CONTAINER_COM_CODIGO_FONTE bash" caso o windows não tenha o docker machine utilize o comando winpty no inicio ex:
   "winpty docker exec -it CONTAINER_COM_CODIGO_FONTE bash"
6º Agora dentro da container, valide se está os fontes dentro, pode acontecer da imagem não criar os fontes, ai terá que ajustar a conteiner.
7º Verifique se dentro do código fonte existe o arquivo, artisan e composer.phar. (as vezes pode não estar sendo versionado no git)
8º Caso esteja tudo ok, executar o comando composer install para pegar atualizar/criar a pasta "vendor" esse comando pode demorar alguns minutos.
9° Ultimo passo é executar o comando "artisan migrate" para adicionar as tabelas e seeds a sua aplicação.
10º A principio está tudo certo agora, teste em sua url.
