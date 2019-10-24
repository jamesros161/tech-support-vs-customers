$(document).ready(function(){
    console.log('GamePlay JS Loaded');
    contact = JSON.parse($('#contact').html());
    console.log(contact);
    
    populateAttacks();
    
    populateIssueResolutions();
    
    populateAgentFields(contact);
    
    populateCxFields(contact);
    
    populateChatBox(contact);
    
    attackOptionChangeEvent(contact);
    
    attackSubmitEvent(contact);
    
    resolveSubmitEvent(contact);
});

var attackOptionChangeEvent = function(contact) {
    avail_attacks = JSON.parse($('#avail-attacks').html());
    $('.attack-select').change(function(event){
       selected_attack = $(this).val();
       $('.attack-select').val('');
       $(this).val(selected_attack);
       console.log(avail_attacks);
       avail_attacks.forEach(function(i){
           if ( i.name == selected_attack ) {
               $('#attack-desc').html('<p>'+i.desc+'</p>');
           }
       });
    });
}

var resolveSubmitEvent = function(contact) {
    $(".iss-res-btn").click(function(){
        issue_resolution = $(this).attr('id');
        resolveIssue(issue_resolution, contact);
    });
}

var attackSubmitEvent = function(contact) {
    $("#attack-submit").click(function(event){
        event.preventDefault();
        attack_values = [];
        $('#attacks-div div select').each(function(i){
            if ( $(this).val() !== '' ) {
                attack_values.push($(this).val());
            }
        });
        if( attack_values.length > 1 ) {
            alert('You can only choose one attack at a time!');
        }
        else if (attack_values.length == 1) {
            avail_attacks.forEach(function(i){
                if ( i.name == attack_values[0] ){
                   performAttack(i, contact);
                }
            });
        }
        
    });
}

var populateChatBox = function(contact) {
    ver = [
        Math.ceil(Math.random() * 9).toString(),
        Math.ceil(Math.random() * 9).toString(),
        Math.ceil(Math.random() * 9).toString(),
        Math.ceil(Math.random() * 9).toString()
        ];
    ver_string =ver[0] + ver[1] + ver[2] + ver[3];
    
    $('#contact_opening').append(
         getTimeStamp() + ' [' + contact.customer_name + ']</br>'
        +'DEPARTMENT: Technical Support</br>'
        +'INQUIRY: ' + contact.category + '</br>'
        +'VERIFICATION: ' + ver_string + '</br>'
        +'QUESTION: ' + contact.issue_string + '</br></br>'
        );
}

var populateAgentFields = function(contact)  {
    $('#agent-sub-header').html(contact.agent_name);
    $('#level').html(contact.agent.level);
    $('#aht').html(contact.aht);
    $('#hmp').html(contact.aht);
    $('#aht-cost').html(contact.agent.ahtcost);
    
    proficiencies = getAgentProficiencies(contact);
    proficiencies.forEach(function(i){
        $('#agent-prof-labels').append('<td id="'+i[0]+'-prof-label">'+i[1]+'</td>');
        $('#agent-prof-values').append('<td id="'+i[0]+'-prof-value">'+i[2]+'</td>');
    });
    
}

var populateCxFields = function(contact) {
    $('#cx-sub-header').html(contact.customer_name);
    $('#cx_proficiency').html(contact.cx_proficiency);
    $('#chp').html(contact.chp);
    $('#ihp').html(contact.ihp);
}

var getAgentProficiencies = function(contact) {
    proficiencies = []
    for (var agent_prop of Object.keys(contact.agent)) {
        if ( typeof contact.agent[agent_prop] === 'object' && contact.agent[agent_prop] !== null ) {
            skill_names = contact.agent[agent_prop]['skill_names'];
            for (var i in skill_names) {
                skill_name = contact.agent[agent_prop]['skill_names'][i];
                if ( contact.agent[agent_prop][skill_name][1] > 0 ) {
                    proficiencies.push([skill_name, contact.agent[agent_prop][skill_name][0],contact.agent[agent_prop][skill_name][1]])
                }
            }
        }
    }
    return proficiencies;
}

var populateIssueResolutions = function() {
    issue_resolutions = JSON.parse($('#issue-resolutions').html());
    $('#issue-resolutions-div').append('<div class="mar-10"><h4>Issue Resolutions</h4></div>');
    issue_resolutions.forEach(function(i){
        $('#issue-resolutions-div').append(
            '<div class="btn btn-primary iss-res-btn" id="' + i.name + '" value="' + i.name + '">' + i.display_name + '</button>'
            );
    });
};

var populateAttacks = function() {
    attack_types = JSON.parse($('#attack-types').html());
    avail_attacks = JSON.parse($('#avail-attacks').html());
    $('#attacks-div').append('<div class="mar-10"><h4>Attacks</h4></div>');
    for (var key in attack_types) {
        $('#attacks-div').append(
               '<div class="flex-column mar-10" style="width:15%" id='+key+'>'
              +'    <p>' + attack_types[key] + '</p>'
              +'    <select class="form-control attack-select" style="width:100%" name="'+key+'">' + printAttacksOfType(avail_attacks, key) + '</select>'
              +'</div>');
    }
    $('#attacks-div').append('<div id="attack-submit" style="width:15%" class="btn btn-primary mar-10">Attack</div>');
};

var getTimeStamp = function() {
    var today = new Date();
    return pad(today.getHours()) + ":" + pad(today.getMinutes()) + ":" + pad(today.getSeconds());
};

var pad = function(n) {
    return String("00" + n).slice(-2);
};

var getSkillDisplayName = function(skill) {
    contact = JSON.parse($('#contact').html());
    for (var agent_prop of Object.keys(contact.agent)) {
        if ( typeof contact.agent[agent_prop] === 'object' && contact.agent[agent_prop] !== null ) {
            skill_names = contact.agent[agent_prop]['skill_names'];
            for (var i in skill_names) {
                skill_name = contact.agent[agent_prop]['skill_names'][i];
                if ( skill_name == skill ) {
                    return contact.agent[agent_prop][skill_name][0];
                }
            }
        }
    }
}

var printAttacksOfType = function(attacks, type) {
    printString = '<option value=""></option>';
    attacks.forEach(function(attack){
        if ( attack.type == type ) {
            display_name = attack.display_name;
            skill = getSkillDisplayName(attack.skill);
            printString = printString+'<option value="'+attack.name+'" title="Skill Profiency: '+skill+'">'+ display_name +'</option>';
        }
    });
    return printString;
};

var changeColor = function(existing_stat, new_stat_amnt, stat_element) {
    if ( existing_stat > new_stat_amnt ) {
                stat_element.style.color = 'red';
            }
            else if ( existing_stat < new_stat_amnt ) {
                stat_element.style.color = 'green';
            }
            else {
                stat_element.style.color = 'black';
            }
};

var attackMeetsRequires = function(attack, skill_proficiency) {
    if ( attack.effects.requires.mult_type == 'less-base*mult' ) {
        multiplier = parseInt(attack.effects.requires.multiplier) * parseInt(skill_proficiency);
        requirement = parseInt(attack.effects.requires.base_amt) + multiplier;
        req_string = ' is less than ';
        stat = attack.effects.requires.stat;
        stat_value = $('#' + stat).html();
        if ( stat_value <= requirement ) {
            return true;
        }
        else {
            agent_name = $('#agent-sub-header').html();
            sendMessage(agent_name, '"' + attack.display_name + '" Requires that ' + getFormattedStat(attack.effects.requires.stat) + req_string + requirement, color='red');
            return false;
        }
    }
    return true;
};

var resolveIssue = function(resolution, contact) {
    issue_resolutions = JSON.parse($('#issue-resolutions').html());
    var skill;
    issue_resolutions.forEach(function(i){
        if ( i.name == resolution ) {
            skill = i.skill;
            resolution = i;
        }
    });
    skill_proficiency = '';
    for (var agent_prop of Object.keys(contact.agent)) {
        if ( typeof contact.agent[agent_prop] === 'object' && contact.agent[agent_prop] !== null ) {
            if ( contact.agent[agent_prop].hasOwnProperty(skill) ){
                skill_proficiency = contact.agent[agent_prop][skill][1];
            }
        }
    }
    agent_roll = Math.ceil(Math.random() * 10);
    agent_roll = parseInt(agent_roll) + parseInt(skill_proficiency);
    cx_roll = Math.ceil(Math.random() * 10);
    cx_proficiency = $('#cx_proficiency').html();
    cx_roll = parseInt(cx_roll) + parseInt(cx_proficiency);
    
    if ( agent_roll > cx_roll ) {
        amt = agent_roll - cx_roll;
        calcResolution(skill_proficiency, amt, contact, resolution, 'success');
    }
    
    else if ( agent_roll < cx_roll ) {
        amt = parseInt(cx_roll) - parseInt(agent_roll);
        calcResolution(skill_proficiency, amt, contact, resolution, 'fail');
    }
    
    else {
        amt = 1;
        calcResolution(skill_proficiency, amt, contact, resolution, 'fail');
    }
    game_over = runAgentTurn();
    if (game_over !== true) {
        runCxTurn();
    }
    

}
var runAgentTurn = function() {
    console.log("Start Agent Turn");
    contact = JSON.parse($('#contact').html());
    ahtcost = parseInt($('#aht-cost').html());
    existing_aht = parseInt($('#aht').html());
    new_aht = existing_aht - ahtcost;
    $('#aht').html(parseInt($('#aht').html()) - ahtcost);
    changeColor(existing_aht, new_aht, document.getElementById('aht'));
    
    
    if ( parseInt($('#aht').html()) <= 0 ) {
        youLose('Contact Has Exceeded AHT');
        return true;
    }
    if ( parseInt($('#hmp').html()) <= 0 ) {
        youLose('You Have Run Out of Ideas');
        return true;
    }
    
    if ( parseInt($('#chp').html()) <= 0 ) {
        youWin('The Customer has given up and dropped chat');
        return true;
    }
    if ( parseInt($('#ihp').html()) <= 0 ) {
        youWin('You have resolved the issue');
        return true;
    }
    return false;
}

var runCxTurn = function() {
    contact = contact = JSON.parse($('#contact').html());
    console.log("Start Cx Turn");
    customerStances = JSON.parse($('#customer-stances').html());
    roll_to_match = Math.ceil(Math.random() * 10);
    cx_roll = Math.ceil(Math.random() * 10);
    if ( cx_roll != roll_to_match) {
        newStance = rollForStance(customerStances);
    }
    else {
        newStance = false;
    }
    if (newStance !== false) {
        applyStance(newStance);
    }
}

var applyStance = function(newStance) {
    console.log(newStance);
    stance = newStance[0];
    stanceSoF = newStance[1];
    if ( stance.type == 'rollvroll' ) {
        stance_name = stance.name
        affected_attr = stance.effects['success'][0];
        effect_val = stance.effects['success'][1];
        rand_response_number = Math.ceil(Math.random() * (stance.responses.length)) - 1;
        console.log(rand_response_number);
        response = stance.responses[rand_response_number];
        sendMessage($('#cx-sub-header').html(), '***Cx is '+stance_name+'*** '+response, color='black');
    }
    if ( stance.type == 'evenodd' ) {
        stance_name = stance.name
        affected_attr = stance.effects['success'][0];
        effect_val = stance.effects['success'][1];
        rand_response_number = Math.ceil(Math.random() * (stance.responses.length)) - 1;
        console.log(rand_response_number);
        response = stance.responses[rand_response_number];
        sendMessage($('#cx-sub-header').html(), '***Cx is '+stance_name+'*** '+response, color='black');
    }
    if ( stance.type == 'reset' ) {
        stance_name = stance.name
        affected_attr = stance.effects['success'][0];
        effect_val = stance.effects['success'][1];
        rand_response_number = Math.ceil(Math.random() * (stance.responses.length)) - 1;
        console.log(rand_response_number);
        response = stance.responses[rand_response_number];
        sendMessage($('#cx-sub-header').html(), '***Cx is '+stance_name+'*** '+response, color='black');
    }
    
}

var rollForStance = function(customerStances) {
    stance_selection = Math.ceil(Math.random() * 6);
    agent_profs = [
        parseInt($('#contact_control-prof-value').html()),
        parseInt($('#de_escalation-prof-value').html()),
        parseInt($('#confidence-prof-value').html()),
        parseInt($('#charm-prof-value').html()),
        ]
    agent_prof_selection = (Math.ceil(Math.random() * 4)) - 1;
    agent_proficiency = agent_profs[agent_prof_selection];
    active_stance = false;
    customerStances.forEach(function(i){
        if ( i.number == stance_selection ) {
            customer_stance = i;
            if ( customer_stance.type == 'rollvroll' ) {
                agent_roll = agent_proficiency;
                cx_roll = Math.ceil(Math.random() * 10)
                if ( cx_roll > agent_roll ) {
                    active_stance = [i, 'success'];
                    return;
                }
                else {
                    active_stance = false;
                    return;
                }
            } else if ( customer_stance.type == 'evenodd' ){
                if ( isOdd(cx_roll) ) {
                    active_stance = [customer_stance, 'fail'];
                    return;
                } else {
                    active_stance = [customer_stance, 'success'];
                    return;
                }
            } else if ( customer_stance.type == 'reset'){
                agent_roll = (Math.ceil(Math.random() * 10)) + agent_proficiency;
                cx_roll = Math.ceil(Math.random() * 10)
                if ( cx_roll > agent_roll ) {
                    active_stance = [customer_stance, 'success'];
                    return;
                }
                else {
                    active_stance = false;
                    return;
                }
            }
        }
    });
    console.log(active_stance);
    return active_stance;
}
var isOdd = function(num) {
    return num % 2;
}
var calcResolution = function(skill_proficiency, amt, contact, resolution, success_or_fail) {
    existing_ihp = document.getElementById('ihp').innerHTML;
    existing_hmp = document.getElementById('hmp').innerHTML;
    existing_aht = document.getElementById('aht').innerHTML;
    agent_name = $('#agent-sub-header').html()
    
    if ( parseInt(existing_hmp) >= 10) {
        if ( success_or_fail == 'success' ) {
            total_effect = amt * 10;
            new_ihp = parseInt(existing_ihp) - total_effect;
            changeColor(existing_ihp, new_ihp, document.getElementById('ihp'));
            document.getElementById('ihp').innerHTML = new_ihp
            document.getElementById('hmp').innerHTML = parseInt(existing_hmp) - 10
            changeColor(existing_hmp, existing_hmp - 10, document.getElementById('hmp'));
            sendMessage(
                agent_name, 
                'At a cost of 10 HMP, ' 
                + agent_name + getSoFString(success_or_fail) + resolution.display_name 
                + '" and resolved the issue by ' + total_effect,
                getSoFColor(success_or_fail)
            );
        }
        if ( success_or_fail == 'fail' ) {
            total_effect = amt * 10;
            new_aht = parseInt(existing_aht) - total_effect;
            changeColor(existing_aht, new_aht, document.getElementById('aht'));
            document.getElementById('aht').innerHTML = new_aht;
            sendMessage(
                agent_name, 
                'At a cost of 10 HMP, ' 
                + agent_name + getSoFString(success_or_fail) + resolution.display_name 
                + '" and received ' + total_effect + ' damage to AHT',
                getSoFColor(success_or_fail)
            );
        }
    }
    else {
        sendMessage(agent_name, 'Insufficent Hackerman Points. Go Get Gud', color='red');
        return;
    }
}

var performAttack = function(attack, contact) {
    skill = attack.skill;
    skill_proficiency = '';
    for (var agent_prop of Object.keys(contact.agent)) {
        if ( typeof contact.agent[agent_prop] === 'object' && contact.agent[agent_prop] !== null ) {
            if ( contact.agent[agent_prop].hasOwnProperty(skill) ){
                skill_proficiency = contact.agent[agent_prop][skill][1];
            }
        }
    }
    if ( attack.effects.hasOwnProperty('requires')) {
        if (attackMeetsRequires(attack, skill_proficiency) === false ) {
            return false
        }
    }
    agent_roll = Math.ceil(Math.random() * 10);
    agent_roll = parseInt(agent_roll) + parseInt(skill_proficiency);
    cx_roll = Math.ceil(Math.random() * 10);
    cx_proficiency = $('#cx_proficiency').html();
    cx_roll = parseInt(cx_roll) + parseInt(cx_proficiency);
    if ( agent_roll >= cx_roll ) {
        amt = agent_roll - cx_roll;
        calcAttack(skill_proficiency, amt, contact, attack, 'success');
    }
    else {
        console.log("cx wins");
        amt = cx_roll - agent_roll;
        calcAttack(skill_proficiency, amt, contact, attack, 'fail');
    }
    resetSelections();
    game_over = runAgentTurn();
    if (game_over !== true) {
        runCxTurn();
    }
};

var resetSelections = function() {
    selects = $('select')
    selects.each(function(){
        $(this).val('');
    });
}

var youLose = function(msg) {
    $('.btn').hide();
    $('#content').append(
         '<div style="display:flex;justify-content:center;flex-direction:column">'
        +'<h3 style="color:red;text-align:center">'+ msg + '</br>You Lose</h3>'
        +'<a class="btn btn-primary" href="newcontact.php">New Contact</a></div>');
    scroll_pos = $('#content').scrollTop()
    scroll_height = $('#content').prop('scrollHeight');
    $('#content').scrollTop(scroll_height);
}

var youWin = function(msg) {
    $('.btn').hide();
    xp_amt = contact.agent.level * 100;
    console.log(contact.agent.xptolvlup)
    if ( contact.agent.xptolvlup - xp_amt <= 0 ) {
        xp_response = $.post(
            '/gainxp.php',
            {"agent_id":  contact.agent.id, "xp": xp_amt}
        );
    
        $('#content').append(
             '<div style="display:flex;justify-content:center;flex-direction:column">'
            +'<h3 style="color:green;text-align:center">'+ msg + '</br>You Win</h3>'
            +'<h3 style="color:green;text-align:center">You Leveled Up</h3>'
            +'<a class="btn btn-primary" href="levelup.php?action=level_up">Assign Skill Points</a></div>');

    }
    else {
        xp_response = $.post(
            '/gainxp.php',
            {"agent_id":  contact.agent.id, "xp": xp_amt}
        );
        
        $('#content').append(
             '<div style="display:flex;justify-content:center;flex-direction:column">'
            +'<h3 style="color:green;text-align:center">'+ msg + '</br>You Win</h3>'
            +'<h3 style="color:green;text-align:center">You Earned '+ xp_amt +' XP</h3>'
            +'<a class="btn btn-primary" href="newcontact.php">New Contact</a></div>');
    }
    scroll_pos = $('#content').scrollTop()
    scroll_height = $('#content').prop('scrollHeight');
    $('#content').scrollTop(scroll_height);
}

var sendMessage = function(name, message, color='blue') {
    message = getTimeStamp() + ' [' + name + '] ' + message
    string = '<p style="color:'+ color + '">' + message + '</p>'
    $('#content').append(string);
    scroll_pos = $('#content').scrollTop()
    scroll_height = $('#content').prop('scrollHeight');
    $('#content').scrollTop(scroll_height);
}

var getSoFString = function(success_or_fail) {
    if ( success_or_fail == 'success') {
        return ' successfully uses "';
    }
    else {
        return ' fails to use "';
    }
}

var getSoFColor = function(success_or_fail) {
    if ( success_or_fail == 'success') {
        return 'blue';
    }
    else {
        return 'red';
    }
}
var getFormattedStat = function(stat) {
    stats = {
        "aht": "AHT",
        "hmp": "HMP",
        "cx_proficiency": "Cx Proficiency",
        "chp": "Cx HP",
        "ihp": "Issue HP"
    }
        
    return stats[stat]
}

var getAffectedStatsString = function(affected_stats) {
    affected_stats_str = ''
    if ( attack_affected_stats.length > 1 ) {
        attack_affected_stats.forEach(function(stat) {
            if ( attack_affected_stats[0] == stat ){
                affected_stats_str = getFormattedStat(stat);
            }
            else if ( attack_affected_stats[attack_affected_stats.length -1] == stat ){
                affected_stats_str = affected_stats_str + ' and ' + getFormattedStat(stat);
            }
            else {
                affected_stats_str = affected_stats_str + ', ' + getFormattedStat(stat);
            }
        });
    }
    else {
        affected_stats_str = getFormattedStat(attack_affected_stats[0]);
    }
    return affected_stats_str;
}

var calcAttack = function(skill_proficiency, amt, contact, attack, success_or_fail) {
    attack_affected_stats = attack.effects[success_or_fail]['affected_stats'];
    attack_base_amt = attack.effects[success_or_fail]['base_amt'];
    attack_mult_type = attack.effects[success_or_fail]['mult_type'];
    attack_multiplier = attack.effects[success_or_fail]['multiplier'];
    if ( attack_mult_type == 'base+mult' ) {
            addBasePlusMultBonus(attack, attack_affected_stats, attack_base_amt, attack_mult_type, attack_multiplier, skill_proficiency, attack.cost, success_or_fail);
        }
    if ( attack_mult_type == 'stat+base' ) {
            addBase(attack, attack_affected_stats, attack_base_amt, attack_mult_type, attack_multiplier, skill_proficiency, attack.cost, success_or_fail);
        }
    if ( attack_mult_type == 'base-mult' ) {
            subBaseLessMultBonus(attack, attack_affected_stats, attack_base_amt, attack_mult_type, attack_multiplier, skill_proficiency, attack.cost, success_or_fail);
        }
    if ( attack_mult_type == 'sub-mult' ) {
            subMultBonus(attack, attack_affected_stats, attack_base_amt, attack_mult_type, attack_multiplier, skill_proficiency, attack.cost, success_or_fail);
        }
    if ( attack_mult_type == 'sub-percent' ) {
            subPercentEffect(attack, attack_affected_stats, attack_base_amt, attack_mult_type, attack_multiplier, skill_proficiency, attack.cost, success_or_fail);
        }
    if ( attack_mult_type == 'reduce-absolute' ) {
            reduceAbsoluteEffect(attack, attack_affected_stats, attack_base_amt, attack_mult_type, attack_multiplier, skill_proficiency, attack.cost, success_or_fail);
        }
};

var addBasePlusMultBonus = function(attack, attack_affected_stats, attack_base_amt, attack_mult_type, attack_multiplier, skill_proficiency, cost, SoF) {
    for (var i in attack_affected_stats) {
        existing_stat = document.getElementById(attack_affected_stats[i]).innerHTML;
        existing_hmp = document.getElementById('hmp').innerHTML;
        if ( existing_hmp >= cost) {
            console.log(attack)
            multiplier_bonus = skill_proficiency * attack_multiplier;
            total_effect = multiplier_bonus + attack_base_amt;
            new_stat_amnt = parseInt(existing_stat) + total_effect;
            document.getElementById(attack_affected_stats[i]).innerHTML = new_stat_amnt;
            changeColor(existing_stat, new_stat_amnt, document.getElementById(attack_affected_stats[i]));
            document.getElementById('hmp').innerHTML = existing_hmp - parseInt(cost);
            changeColor(existing_hmp, parseInt(document.getElementById('hmp').innerHTML), document.getElementById('hmp'));
        }
        else {
            agent_name = $('#agent-sub-header').html()
            sendMessage(agent_name, 'Insufficent Hackerman Points. Go Get Gud', color='red');
            return;
        }
    }
    agent_name = $('#agent-sub-header').html();
    stats_string = getAffectedStatsString(attack_affected_stats);
        sendMessage(
            agent_name, 
            'At a cost of ' + cost + ' HMP, ' 
            + agent_name + getSoFString(SoF) + attack.display_name 
            + '" and increases ' + stats_string + ' by ' + total_effect,
            getSoFColor(SoF)
            );
};

var addBase = function(attack, attack_affected_stats, attack_base_amt, attack_mult_type, attack_multiplier, skill_proficiency, cost, SoF) {
    for (var i in attack_affected_stats) {
        existing_stat = document.getElementById(attack_affected_stats[i]).innerHTML;
        existing_hmp = document.getElementById('hmp').innerHTML;
        if ( existing_hmp >= cost) {
            total_effect = attack_base_amt;
            new_stat_amnt = parseInt(existing_stat) + total_effect;
            document.getElementById(attack_affected_stats[i]).innerHTML = new_stat_amnt;
            changeColor(existing_stat, new_stat_amnt, document.getElementById(attack_affected_stats[i]));
            document.getElementById('hmp').innerHTML = existing_hmp - parseInt(cost);
            changeColor(existing_hmp, parseInt(document.getElementById('hmp').innerHTML), document.getElementById('hmp'));
        }
        else {
            agent_name = $('#agent-sub-header').html()
            sendMessage(agent_name, 'Insufficent Hackerman Points. Go Get Gud', color='red');
            return;
        }
    }
    agent_name = $('#agent-sub-header').html();
    stats_string = getAffectedStatsString(attack_affected_stats);
        sendMessage(
            agent_name, 
            'At a cost of ' + cost + ' HMP, ' 
            + agent_name + getSoFString(SoF) + attack.display_name 
            + '" and increases ' + stats_string + ' by ' + total_effect,
            getSoFColor(SoF)
            );
};
    
var subBaseLessMultBonus = function(attack, attack_affected_stats, attack_base_amt, attack_mult_type, attack_multiplier, skill_proficiency, cost, SoF) {
    for (var i in attack_affected_stats) {
        existing_stat = document.getElementById(attack_affected_stats[i]).innerHTML;
        existing_hmp = document.getElementById('hmp').innerHTML;
        if ( existing_hmp >= cost) {
            multiplier_bonus = skill_proficiency * attack_multiplier;
            total_effect = attack_base_amt - multiplier_bonus;
            new_stat_amnt = parseInt(existing_stat) - total_effect;
            document.getElementById(attack_affected_stats[i]).innerHTML = new_stat_amnt;
            changeColor(existing_stat, new_stat_amnt, document.getElementById(attack_affected_stats[i]));
            document.getElementById('hmp').innerHTML = existing_hmp - parseInt(cost);
            changeColor(existing_hmp, parseInt(document.getElementById('hmp').innerHTML), document.getElementById('hmp'));
        }
        else {
            agent_name = $('#agent-sub-header').html()
            sendMessage(agent_name, 'Insufficent Hackerman Points. Go Get Gud', color='red');
            return
        }
    }
    agent_name = $('#agent-sub-header').html();
    stats_string = getAffectedStatsString(attack_affected_stats);
        sendMessage(
            agent_name, 
            'At a cost of ' + cost + ' HMP, ' 
            + agent_name + getSoFString(SoF) + attack.display_name 
            + '" and decreases ' + stats_string + ' by ' + total_effect,
            getSoFColor(SoF)
            );
}

var subMultBonus = function(attack, attack_affected_stats, attack_base_amt, attack_mult_type, attack_multiplier, skill_proficiency, cost, SoF) {
    for (var i in attack_affected_stats) {
        existing_stat = document.getElementById(attack_affected_stats[i]).innerHTML;
        existing_hmp = document.getElementById('hmp').innerHTML;
        if ( existing_hmp >= cost) {
            total_effect = skill_proficiency * attack_multiplier;
            if ( attack_base_amt > total_effect ) {
                total_effect = attack_base_amt;
            }
            new_stat_amnt = parseInt(existing_stat) - total_effect;
            document.getElementById(attack_affected_stats[i]).innerHTML = new_stat_amnt;
            changeColor(existing_stat, new_stat_amnt, document.getElementById(attack_affected_stats[i]));
            document.getElementById('hmp').innerHTML = existing_hmp - parseInt(cost);
            changeColor(existing_hmp, parseInt(document.getElementById('hmp').innerHTML), document.getElementById('hmp'));
        }
        else {
            agent_name = $('#agent-sub-header').html()
            sendMessage(agent_name, 'Insufficent Hackerman Points. Go Get Gud', color='red');
            return;
        }
    }
    agent_name = $('#agent-sub-header').html();
    stats_string = getAffectedStatsString(attack_affected_stats);
    sendMessage(
        agent_name, 
        'At a cost of ' + cost + ' HMP, ' 
        + agent_name + getSoFString(SoF) + attack.display_name 
        + '" and decreases ' + stats_string + ' by ' + total_effect,
        getSoFColor(SoF)
        );
}

var subPercentEffect = function(attack, attack_affected_stats, attack_base_amt, attack_mult_type, attack_multiplier, skill_proficiency, cost, SoF) {
    for (var i in attack_affected_stats) {
        existing_stat = document.getElementById(attack_affected_stats[i]).innerHTML;
        existing_hmp = document.getElementById('hmp').innerHTML;
        if ( existing_hmp >= cost) {
            if ( attack_multiplier != 'none' ) {
                multiplier_bonus = skill_proficiency * attack_multiplier;
            }
            else {
                multiplier_bonus = 1;
            }
            amt = attack_base_amt / 100;
            percent_damage = existing_stat * amt;
            total_effect = percent_damage * multiplier_bonus;
            new_stat_amnt = parseInt(existing_stat) - total_effect;
            document.getElementById(attack_affected_stats[i]).innerHTML = new_stat_amnt;
            changeColor(existing_stat, new_stat_amnt, document.getElementById(attack_affected_stats[i]));
            document.getElementById('hmp').innerHTML = existing_hmp - parseInt(cost);
            changeColor(existing_hmp, parseInt(document.getElementById('hmp').innerHTML), document.getElementById('hmp'));
        }
        else {
            agent_name = $('#agent-sub-header').html()
            sendMessage(agent_name, 'Insufficent Hackerman Points. Go Get Gud', color='red');
            return;
        }
    }
    agent_name = $('#agent-sub-header').html();
    stats_string = getAffectedStatsString(attack_affected_stats);
        sendMessage(
            agent_name, 
            'At a cost of ' + cost + ' HMP, ' 
            + agent_name + getSoFString(SoF) + attack.display_name 
            + '" and decreases ' + stats_string + ' by ' + total_effect,
            getSoFColor(SoF)
            );
}

var reduceAbsoluteEffect = function(attack, attack_affected_stats, attack_base_amt, attack_mult_type, attack_multiplier, skill_proficiency, cost, SoF) {
    for (var i in attack_affected_stats) {
        existing_stat = document.getElementById(attack_affected_stats[i]).innerHTML;
        existing_hmp = document.getElementById('hmp').innerHTML;
        if ( existing_stat > attack_base_amt ) {
            if ( existing_hmp >= cost) {
                total_effect = attack_base_amt;
                new_stat_amnt = total_effect;
                document.getElementById(attack_affected_stats[i]).innerHTML = new_stat_amnt;
                changeColor(existing_stat, new_stat_amnt, document.getElementById(attack_affected_stats[i]));
                document.getElementById('hmp').innerHTML = existing_hmp - parseInt(cost);
                changeColor(existing_hmp, parseInt(document.getElementById('hmp').innerHTML), document.getElementById('hmp'));
            }
            else {
                agent_name = $('#agent-sub-header').html()
                sendMessage(agent_name, 'Insufficent Hackerman Points. Go Get Gud', color='red');
                return;
            }
        }
        else {
            agent_name = $('#agent-sub-header').html()
            sendMessage(
                agent_name,
                getAffectedStatsString(attack_affected_stats) 
                + ' is already lower than ' + attack_base_amt 
                + '. Try doing something useful instead.',
                color='red');
            return;
            }
    }
    agent_name = $('#agent-sub-header').html()
    stats_string = getAffectedStatsString(attack_affected_stats);
    sendMessage(
        agent_name, 
        'At a cost of ' + cost + ' HMP, ' 
        + agent_name + getSoFString(SoF) + attack.display_name 
        + '" and sets ' + stats_string + ' to ' + total_effect,
        getSoFColor(SoF)
        );
}