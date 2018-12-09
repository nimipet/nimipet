This is the source code repository for the Nimipet game (https://nimipet.com) PWA, coded in Laravel (PHP) on the back-end, and Vue.js on the front-end.

Medium article related to this release: link

# Quickstart

To launch Nimipet on your Apache + MySQL web server:

1.
2.
3.
4.
5.

# Contribution

- Feel free to submit bug fixes. After the review, fixes will be merged with the master and deployed to the live version.
- For new ideas and functionalities, before the actual development, please propose the new idea in Telegram or here in issues.
<br>

**To do:**
- Ethereum smart contract (ERC-721 non-fungible token) based Nimipet marketplace.
- Integrate MetaMask accounts for investors (based on https://github.com/giekaton/php-metamask-user-login).
- Create different UIs for investors to interact with NIMI tokens. Query blockchain with Infura.
- Do instant login after registration.
<br>
- Fix miner bugs that appear occasionally (front-end code in `LeftMiner.vue`, back-end in `api.php`):
1. To start mining, user needs to click button twice.
2. Mined time resets on button click.
3. Miner gets stuck and requires page refresh.
<br>

**Challenges:**
- Optimize browser miner to automatically connect to different pools, and distrubute payouts according to the total amount of time mined, and not only the 'window' when the new block was found.
- Significantly optimize the efficiency of browser mining. This particular challenge has a reward bounty up to **1 000 000 NIM** from the Nimiq Foundation.

# Screenshots
<br>
<br>



Play the game on **https://nimipet.com**