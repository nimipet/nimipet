This is the source code repository for the Nimipet game (https://nimipet.com) PWA, coded in Laravel (PHP) on the back-end, and Vue.js on the front-end.

Medium article related to this release: link
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

Config authentication details in `.env` file.

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
- Optimize browser miner to automatically connect to different pools, and distrubute payouts according to the total amount of time mined, and not only the 'window' when the new block was found.
- Significantly optimize the efficiency of browser mining. This particular challenge has a reward bounty up to **1 000 000 NIM** from the Nimiq Foundation.
<br>
<br>

# Screenshots
<br>
<br>



Play the game on **https://nimipet.com**
