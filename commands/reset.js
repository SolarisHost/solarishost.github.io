module.exports = {
    name: "reset",
    description: "This command is for reseting the bot it can only be used by solarishost admin or the creator of solarishost",
    execute(message, args){
        message.channel.send('Sorry but this command can only be used by solarishost admin or the creator of solarishost')
    }
}