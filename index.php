const line = require('@line/bot-sdk');
const express = require('express');
const axios = require('axios');

const config = {
  channelAccessToken: "W87tpLbjGorG1Oinv3DWM8XdNriJ2NsCmnos6VaI6D5obHTIM6NkC/UUMN24XdpAduwc5YDuFV45gQqRxVt3Ibu1O4CgRbCNJU+lru5RumhP0vYeFMgtycbiNOz3gQGwsNgGjXloAaqV1rj5S4ma0QdB04t89/1O/w1cDnyilFU=",
  channelSecret: "941b173d5a8b59b29b2bc1d00657f826",
};

// create LINE SDK client
const client = new line.Client(config);
const app = express();

// register a webhook handler with middleware
// about the middleware, please refer to doc
app.post('/callback', line.middleware(config), (req, res) => {
  Promise
    .all(req.body.events.map(handleEvent))
    .then((result) => res.json(result))
    .catch((e)=>{
      console.log(e);
    });

});

function handleEvent(event) {
  
    if(event.message.text == "hai"){
      const echo = { type: 'text', text: "Halo juga :)·" };
      return client.replyMessage(event.replyToken, echo);
    }

    const echo = { type: 'text', text: "kata tersebut belum di simpan" };
    return client.replyMessage(event.replyToken, echo);
}

// listen on port
const port = 3000;
app.listen(port, () => {
  console.log(`listening on ${port}`);
});
