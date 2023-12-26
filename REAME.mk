# Desafio-STW
A produção de uma fábrica de farinhas trabalha diariamente com diversos tipos de receitas.
Essas receitas possuem um conjunto de ingredientes que devem ser consumidos na ordem em que foram salvos.
Atualmente as receitas já estão organizadas em planilhas do Excel e são impressas sempre que uma receita é finalizada.
O desafio é implementar o frontend e backend de uma aplicação web para cadastro de receitas para eliminar a impressão em papel e facilitar o gerenciamento das mesmas.


A aplicação deve ter as seguintes funcionalidades:
1. Receitas
  - [x] Listar receitas
  - [x] Listar uma determinada receita com seus respectivos ingredientes
  - [x] Adicionar uma nova receita com seus respectivos ingredientes
  - [x] Atualizar uma receita com seus respectivos ingredientes
  - [x] Excluir uma receita

2. Ingredientes
  - [x] Listar os ingredientes
  - [x] Adicionar um novo ingrediente
  - [x] Atualizar um ingrediente
  - [x] Excluir um ingrediente

---

# Sumário

- [Tecnologias utilizadas](#tecnologias-utilizadas)
- [Ferramentas necessárias](#ferramentas-necessárias)
- [Rodando no servidor local](#rodando-no-servidor-local)
- [Orientações de como utilizar](#orientações-de-como-utilizar)
- [Habilidades desenvolvidas](#habilidades-desenvolvidas)

  ---

# Tecnologias utilizadas

- [Postman](https://www.postman.com/)
- [Laravel](https://laravel.com/)
- [PHP](https://www.php.net/)
- [Vue.js](https://vuejs.org/)
- [Javascript](https://developer.mozilla.org/pt-BR/docs/Web/JavaScript)
- [HTML](https://developer.mozilla.org/pt-BR/docs/Web/HTML)
- [CSS](https://developer.mozilla.org/pt-BR/docs/Web/CSS)
- [MySQL](https://www.mysql.com/)
- [XAMPP](https://www.apachefriends.org/pt_br/index.html)

---

# Como utilizar

## Ferramentas necessárias

 * Para rodar o projeto, você vai precisar instalar as seguintes ferramentas:
[XAMPP](https://www.apachefriends.org/pt_br/index.html) (que vai trazer alguns programas como o PHP)
* Um editor para trabalhar com o código como [VSCode](https://code.visualstudio.com/) ou outro de sua preferência;

 ## Rodando no servidor local

- Dentro do painel do "XAMPP":
  - Clicar em "start", tanto no "Apache" quanto no "MySQL". Que deverá ficar assim:
  - (imagem)

 - Clone do Projeto

    - Clone este repositório dentro de um pasta que esteja dentro desse caminho: C:\xampp\htdocs
    git clone https://github.com/LeandroGoerck/desafio-stw.git
    
    - Configure o Banco de Dados
  - No terminal do XAMPP aperte no botão "Admin" na coluna da opção "MySQL";
  - Dentro do phpMyAdmin, crie uma base de dados com o nome que desejar;
  - Dentro da pasta "backend" acesse o arquivo ".env", e renomeie o valor de "DB_DATABASE" passando o nome daquele que você criou;
  - (./imagem/bancoDeDados.png) 
    
 - Inicie o sistema:

    - Inicie o backend:
    cd backend && php artisan serve

    - Em outro terminal, inicie o frontend:
    cd frontend && npm start

    Abra no navegador os links que aparecem nos dois terminais. Eles devem ser algo como "http://localhost/..."

---

  # Um pouco sobre minha experiência
Foi um grande desafio pra mim, já que eu nunca tinha entrado em contato com PHP, Laravel e Vue.js. Eu já tinha visto alguns conteúdos sobre essas tecnologias mas nada algo muito profundo como foi nesse projeto. Tive que me organizar de forma a poder conseguir estudar o básico para conseguir pelo menos entregar um projeto funcional. Então dividi meus 3 primeiros dias para estudar as tecnologias que não conhecia profundamente (separei um dia pra cada). E depois foquei no desenvolvimento do projeto mesmo, pesquisando bastante até encontrar a solução de um problema que havia encontrado, ou para poder terminar alguma funcionalidade que não tinha muita noção de como implementar.

Eu já escutei que as principais habilidades de um programador são: resolução de problemas, criatividade, comunicação e resiliência. Acho que pude provar pra mim mesmo que eu possuo essas habilidades, além de poder ter melhorado elas durante esse projeto; porque como falei, foi um dos maiores desafios que já fiz em relação à programação. Mas eu também fico animado porque penso no que eu posso fazer, tendo em vista esse desafio que terminei (saindo praticamente do zero), nesse pouco período de tempo. 

E também queria agradecer pela oportunidade de participar desse processo.
