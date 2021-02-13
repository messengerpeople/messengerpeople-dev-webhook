/**
 *  Very simple (node) js example for a webhook for MessengerPeople.dev API
 *
 *  @summary Lightweight webhook for app.messengerpeople.dev
 *  @author [Jan Uhrig](mailto:j.uhrig94@gmail.com)
 *
 */


const verificationToken = "your-verification-code";
const secret = "your-predefined-secret";
const example_body = '{"uuid":"abcdef12-1234-aaaa-4321-abcdef123456","sender":"491721234567","recipient":"ab654321-4321-abcd-4321-987654321abc","payload":{"timestamp":"1571385584","text":"Hello World","user":{"id":"491721234567","name":"Tappy Tester","image":""},"attachment":"","type":"text"},"outgoing":false,"processed":null,"sent":null,"received":null,"read":null,"created":null,"messenger":"WB","messenger_id":"ABEGSRYyNxVAAhD2YdoUOWfO9YXSOWmnigB8"}';
const useExampleBody = false;

app.post("/webhook", (req, res) => {
    if (secret) {
        if (req.header['Authorization'] !== `Bearer ${secret}`) {
            res.status(403).send('Not authorized');
        }
    }

    const body = useExampleBody ? JSON.parse(example_body) : req.body;


    if (body.challenge) {
        if (verificationToken && req.body.verification_token !== verificationToken) {
            res.status(403).send('Not authorized');
        }
        res.body.challenge = body.challenge;
        res.status(200).end(); // Tell MessengerPeople that this webhook belongs to you
    }

    // Process the message - only store it and process the message async
    processMessage(body);

    res.status(200).end(); // Responding with a 200 code
})

function processMessage(message) {
    // Store somewhere and process the message async
    saveToDatabase(message);
    return true;
}

function saveToDatabase(message) {
    return true;
}