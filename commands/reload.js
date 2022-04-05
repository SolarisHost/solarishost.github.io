module.exports = {
    name: "reload",
    description: "This command is for reloading the bot, it can only be used by the bot admin",
    execute(message, args){
        message.channel.send('Sorry but this command can only be used by the bot creator or the bot admin, contact @hixy if you think this is a bug')
    }
}