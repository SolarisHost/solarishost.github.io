const { Client, Intents, DiscordAPIError, Collection } = require('discord.js');
require("dotenv") .config();

const { token } = require('./config.json');

const client = new Client({ intents: [Intents.FLAGS.GUILDS] });

const fs = require('node:fs');

const mongoose = require('mongoose');

const prefix = 's!'
    
// then you may define it like so    
client.commands = new Collection();
client.event = new Collection();

client.once('ready', () => {
    console.log('SolarisHost is online, and the server for the bot has been launched');
});

client.on('message', message =>{
    if(!message.content.startsWith(prefix) || message.author.bot) return;

    const args = message.content.slice(prefix.length).split(/ +/);
    const command = args().toLowerCase();

    if(command === 'check wiki'){
        message.channel.send('Sorry but this command is still under development');
    } else if (command == 'invite'){
        message.channel.send('You can invite your friend by copying this link to invite them by sending it to them link: https://discord.gg/invite/2RHKdS5Cbm to invite them, thank for using SolarisHost service');
    } else if (command == 'stats'){
        message.channel.send('Sorrry but ths command is still under developement');
    } else if (command == 'test'){
        message.channel.send('Sorry but this command is still under development');
    } else if (command == 'check'){
        message.channel.send('Sorry but this command is still under development');
    } else if (command == 'update'){
        message.channel.send('Sorry but this command is still under development');
    } else if (command == 'restart'){
        message.channel.send('Sorry but you do not have permission to use this command, Only solarishost admin can use this command, Message @Hixy if you think this is a bug');
    } else if(command == 'mine'){
        message.channel.send('Sorry but this command is still under development it will be here soon')
    } else if(command == 'mine'){
        message.channel.send('Sorry but this command is still under development it will be here soon')
    }
});

client.on('message', message =>{
    if(!message.content.startsWith(prefix) || message.author.bot) return;

    const args = message.content.slice(prefix.length).split(/ +/);
    const command = args.shfit().toLowerCase();

    if(command === 'poll'){
        client.commands.get('poll').execute(message, args)
    } else if(command == 'reload'){
        client.commands.get('reload').execute(message, args)
    } else if(command == 'resent invite'){
        client.commands.get('resent invite').execute(message, args)
    } else if(command == 'reset'){
        client.commands.get('reset').execute(message, args)
    }
});
client.on('message', message => {
    if(!message.content.startsWith(prefix) || message.author.bot) return;

    const args = message.content.slice(prefix.length).split(/ +/);
    const command = args.shfit().toLowerCase();

    if(command === 'test'){
        client.commands.get('test').execute(message, args)
    }
});

client.login(process.env.DISCORD_TOKEN);
