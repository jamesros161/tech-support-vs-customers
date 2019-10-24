var validateSkillAssign = function(attr_pass_value) {
    if (  attr_pass_value === true ) {
        return true;
    }
    else {
        return false;
    }
}

$(document).ready(function(){
    if ( $('#action').val() == 'assign_skill_points' ) {
        console.log('newagent validation loaded');
        $('.btn-primary').prop('disabled', true);
        $('.btn-primary').parent().append('<span>You must set a value for all attributes');
        initial_roll_values = $('#initial_roll_values').text();
        initial_roll_values = JSON.parse(initial_roll_values);
        initial_roll_values.sort();
        attribute_values = [];
        $('select').change(function(){
            attribute_values = [];
            $('select').each(function(i){
                attribute_values.push(parseInt($(this).val()));
            });
            attribute_values.sort();
            if ( JSON.stringify(attribute_values) == JSON.stringify(initial_roll_values) ) {
                $('.btn-primary').siblings().hide();
                $('.btn-primary').prop('disabled', false);
            }
            else {
                $('.btn-primary').siblings().show();
                $('.btn-primary').prop('disabled', true);
            }
        })
    }
    if ( $('#action').val() == 'submit_new_agent' ) {
        console.log('newagent validation loaded');
        $('.btn-primary').prop('disabled', true);
        $('.btn-primary').parent().siblings().eq(-2).append('You must assign all available skill points');
        attr_list = JSON.parse($('#attribute-list').text());
        attr_pass = []
        attr_list.forEach(function(attr){
            attr_pass[attr]  = false;
            pts_assigned = []
            validated = false
            $('.' + attr  + '-pts-assigned').change(function(){
                attr_list.forEach(function(changed_attr){
                    if ( attr == changed_attr ){
                        attr_pts_avail = $("." + attr + "-pts-avail").text();
                        pts_assigned = []
                        $('.' + attr  + '-pts-assigned').each(function(i){
                            pts_assigned.push(parseInt($(this).val()));
                        });
                        pts_assigned = pts_assigned.reduce((a, b) => a + b, 0);
                        if (attr_pts_avail == pts_assigned) {
                            attr_pass[attr]  = true;
                        }
                        else {
                            attr_pass[attr]  = false;
                        }
                        attr_pass_values = []
                        for (var key in attr_pass) {
                            attr_pass_values.push(attr_pass[key]);
                        }
                        
                        if ( attr_pass_values.every(validateSkillAssign) ) {
                            $('.btn-primary').parent().siblings().eq(-2).hide();
                            $('.btn-primary').prop('disabled', false);
                        }
                        else {
                            $('.btn-primary').parent().siblings().eq(-2).show();
                            $('.btn-primary').prop('disabled', true);
                        }
                        
                        // console.log(validated);
                    }
                });
            });
            
        });
        
    }
});