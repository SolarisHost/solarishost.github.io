module.exports = {
    name: "test",
    description: "This command is for testing the bot it can only be used by solarishost developer and the creator of solarishost",
    execute(message, args){
        message.channel.send('Sorry but this command can only be used by the bot developer or the creator of the bot')
    }
}