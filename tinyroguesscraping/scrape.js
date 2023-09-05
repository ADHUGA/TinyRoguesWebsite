const request = require("request-promise");
const cheerio = require("cheerio");

async function main() {
    const result = await request.get("https://tiny-rogues.fandom.com/wiki/Weapons");
    const $ = cheerio.load(result);
    $("#mw-content-text > div > div > div > table > tbody > tr > td").each((index, element) => {
        console.log($(element).text());
    });
}

main();
