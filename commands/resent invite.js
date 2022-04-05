module.exports = {
    name: "resent invite",
    description: "This command resent the invitation for the discord channel",
    execute(message, args){
        message.channel.send('Thank you for using SolarisHost Bot Service, Here your link to invite someone Link: https://discord.gg/invite/2RHKdS5Cbm')
    }
}