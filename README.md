# 📄 Autocontrato

O Autocontrato foi desenvolvido em setembro de 2023 para a empresa **Booat**, com o objetivo de **criar, enviar e gerenciar contratos automatizados para clientes**.

Esse projeto foi pensado para **automatizar todo o fluxo de geração de contratos**, oferecendo uma experiência integrada tanto para os operadores (administradores) quanto para os clientes finais.

---

## 💡 Funcionalidades principais

### 🧑‍💼 Parte Operador

* Cadastro de clientes e contratos.
* Preenchimento e geração automática de contrato.
* Envio de contrato por e-mail.
* Gestão dos contratos criados (status, envio, datas, etc.).
* Controle completo das cláusulas e informações contratuais.

📌 Os wireframes para a parte operador podem ser visualizados em:
👉 [https://www.figma.com/proto/7Sicres1i4CNBatNiewMhq/WireFrame-Booat-(Parte-Operador)?node-id=4-61&starting-point-node-id=4%3A61&mode=design&t=vPqqTNVGq9X9lfPx-1](https://www.figma.com/proto/7Sicres1i4CNBatNiewMhq/WireFrame-Booat-%28Parte-Operador%29?node-id=4-61&starting-point-node-id=4%3A61&mode=design&t=vPqqTNVGq9X9lfPx-1)

---

### 👤 Parte Cliente

* Recebimento do contrato automaticamente por e-mail.
* Visualização e leitura do contrato no navegador.
* Assinatura digital do contrato diretamente na plataforma.
* Realização de checkout (pagamento) sem sair do sistema.

📌 Os wireframes para a parte cliente estão disponíveis em:
👉 [https://www.figma.com/proto/ul5zejtjV5nWBgmHxO0R5r/WireFrame-Booat-(Parte-Cliente)?node-id=1-2&starting-point-node-id=1%3A2&mode=design&t=sJFmil75vRjSVfoh-1](https://www.figma.com/proto/ul5zejtjV5nWBgmHxO0R5r/WireFrame-Booat-%28Parte-Cliente%29?node-id=1-2&starting-point-node-id=1%3A2&mode=design&t=sJFmil75vRjSVfoh-1)

---

## 🛠️ Tecnologias utilizadas

Este projeto é construído principalmente com:

| Tecnologia             | Função                                |
| ---------------------- | ------------------------------------- |
| **PHP (Laravel)**      | Backend e API                         |
| **JavaScript / Vite**  | Interatividade na interface           |
| **HTML / CSS / Blade** | Frontend templating                   |
| **Banco de Dados**     | Armazenamento de usuários e contratos |

---

## 💳 Checkout e Pagamentos

O **checkout (pagamento)** do Autocontrato é realizado por meio da integração com o **PagSeguro**, permitindo que o cliente finalize a contratação diretamente dentro da plataforma, sem necessidade de redirecionamento externo.

### 🔄 Fluxo de pagamento

1. Após o cliente **visualizar e assinar digitalmente o contrato**, a plataforma libera a etapa de pagamento.
2. O sistema inicia o checkout utilizando a **API do PagSeguro**, enviando os dados do contrato e do cliente.
3. O cliente realiza o pagamento diretamente na interface da aplicação.
4. O PagSeguro processa a transação e retorna o status para o sistema.
5. A plataforma atualiza automaticamente o status do contrato conforme o resultado do pagamento (aprovado, pendente ou recusado).

---

### 🧠 Implementação técnica

* A integração é feita via **PagSeguro (API/SDK oficial)**.
* A lógica de pagamento está concentrada em controllers responsáveis pelo fluxo de checkout.
* As rotas de pagamento ficam definidas na aplicação Laravel, acionando o backend que se comunica com o PagSeguro.
* Após a confirmação da transação, o sistema registra o resultado no banco de dados e libera as próximas etapas do contrato.

---

### 🔐 Segurança

* Os dados sensíveis de pagamento **não são armazenados diretamente na aplicação**.
* Todo o processamento financeiro é feito pelo PagSeguro, garantindo conformidade com boas práticas de segurança.

---

## 📁 Estrutura do projeto

O repositório segue a estrutura padrão de projetos Laravel:

```
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── tests/
├── .env.example
├── composer.json
├── package.json
└── README.md
```

---

## 🚀 Como executar localmente

1. Clone o repositório

   ```bash
   git clone https://github.com/IzzeRodrigues/Booat-Autocontrato.git
   ```
2. Entre na pasta do projeto

   ```bash
   cd Booat-Autocontrato
   ```
3. Instale dependências

   ```bash
   composer install
   npm install
   ```
4. Configure o `.env` com suas credenciais
5. Gere a chave de aplicação

   ```bash
   php artisan key:generate
   ```
6. Rode a aplicação

   ```bash
   php artisan serve
   ```

[1]: https://github.com/IzzeRodrigues/Booat-Autocontrato/tree/main "GitHub - IzzeRodrigues/Booat-Autocontrato"

