![nimi-icon](https://giekaton.com/img/nimi-icon-.png)

This is the source code repository for the Nimipet game (https://nimipet.com) PWA, coded in Laravel (PHP) on the back-end, and Vue.js on the front-end.

Medium article related to this release: [link](https://medium.com/@Nimipet/nimipet-code-rewrite-new-features-marketplace-ff4c820da847)
<br>
<br>
# Quickstart

To launch Nimipet on your Apache + MySQL web server:

```
cd frontend
yarn # OR npm install

# local development server:
yarn serve # OR npm run serve

# build for production:
yarn build # OR npm run build
```

The default config assumes you are serving this Laravel app via `http://nimipet.local/` URL. If you are serving the laravel app at a different local URL, modify it accordingly in `frontend/vue.config.js`.

Rename `.env.example` to `.env` and provide your authentication details.

To create database tables, execute migrate Artisan command: `php artisan migrate`

This Laravel + Vue app structure is based on the [laravel-vue-cli-3](https://github.com/yyx990803/laravel-vue-cli-3) project. For more details, see its docs.

Front-end files are mostly in `/frontend/src/components`.
Back-end in `/routes/api.php`, user auth in `/app/Http/Controllers`.
<br>
<br>
# Contribution

**General:**
- Feel free to submit bug fixes. After the review, fixes will be merged with the master and deployed to the live version.
- For new ideas and functionalities, please before the actual development, propose the new idea in Telegram or here in issues.
<br>

**To do:**
- Ethereum smart contract (ERC-721 non-fungible token) based Nimipet marketplace.
- Integrate MetaMask accounts for investors (based on https://github.com/giekaton/php-metamask-user-login).
- Create different UIs for investors to interact with NIMI tokens. Query blockchain with Infura.
- Do instant login after registration.

- Fix miner bugs that appear occasionally (front-end code in `LeftMiner.vue`, back-end in `api.php`):
1. To start mining, user needs to click button twice.
2. Mined time resets on button click.
3. Miner gets stuck and requires page refresh.
<br>

**Challenges:**
- Optimize browser miner to automatically connect to different pools, and distribute payouts according to the total amount of time mined, and not only the 'window' when the new block was found.
- Significantly optimize the efficiency of browser mining. This particular challenge has a reward bounty up to 1 000 000 NIM from the Nimiq Foundation.
<br>

# What is the Nimipet?

Nimipet is the game where nimipets live.

A nimipet is a digital pet that needs to be fed by virtual pieces of food the player creates by browser-mining Nimiq cryptocurrency.

Nimipet needs to eat at least one piece of food per 24 hours, or it will die and all user points and NIMs will be lost.

To receive one piece of food, the player needs to browser-mine for 15 minutes of time. The maximum amount of food nimipet can eat per day is 200 pieces.

After each feeding, the new 24 hours period starts. If during the 24 hours period nimipet does not receive a new piece of food, it dies.

Each nimipet has its value in NIMs. The more food receives the nimipet, the bigger is its monetary value.
<br>
<br>
**Screenshots**
<br>
<br>
![nimi-01](https://giekaton.com/img/nimi-01-.png)
<br>
![nimi-02](https://giekaton.com/img/nimi-02.png)
<br>
![nimi-03](https://giekaton.com/img/nimi-03.png)
<br>
![nimi-04](https://giekaton.com/img/nimi-04-.png)
<br>
![nimi-05](https://giekaton.com/img/nimi-05-.png)

<br>
<br>

### Play the game at **https://nimipet.com** ###
