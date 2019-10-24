var validateSkillAssign = function(attr_pass_value) {
    if (  attr_pass_value === true ) {
        return true;
    }
    else {
        return false;
    }
}

$(document).ready(function(){
    if ( $('#action').val() == 'update_skill_points' ) {
        console.log('levelup validation loaded');
        $('.btn-primary').prop('disabled', true);
        $('#validation-error').html('<span>You must assign all available attribute points</span>');
        initial_roll_values = $('#initial_roll_values').text();
        initial_roll_values = JSON.parse(initial_roll_values);
        points_avail = $('#points-avail').html();
        initial_roll_values.sort();
        attribute_values = [];
        $('.attribute-input').change(function(){
            attribute_values = [];
            $('.attribute-input').each(function(i){
                if ( isNaN($(this).val()) ) {
                    $(this).val(0);
                }
                if ( $(this).val() == '') {
                    $(this).val(0);
                }
                attribute_values.push(parseInt($(this).val()));
            });
            sum_inputs = 0;
            attribute_values.forEach(function(i){
                sum_inputs = sum_inputs + i;
            });
            attr_name = ($(this).attr('name'));
            attr_orig_val = $('#' + attr_name + '-original-value').html().split(" ")[2]
            attr_new_val = parseInt($(this).val()) + parseInt(attr_orig_val);
            $('#' + attr_name + '-total').html(attr_new_val);
            $('#points-avail').html(points_avail - sum_inputs)
            console.log($('#points-avail').html());
            if ( sum_inputs == points_avail ) {
                $('#validation-error').hide();
                $('.btn-primary').prop('disabled', false);
            }
            else if ( sum_inputs >= points_avail ) {
                $('#validation-error').show();
                $('#validation-error').html('<span>You cannot assign more points than the available points');
                $('.btn-primary').prop('disabled', false);
            }
            else {
                $('#validation-error').show();
                $('.btn-primary').prop('disabled', true);
            }
        })
    }
    if ( $('#action').val() == 'apply_levelup' ) {
        console.log('levelup validation loaded');
        $('.btn-primary').prop('disabled', true);
        $('#validation-error').html('You must assign the correct amount of skill points');
        attr_list = JSON.parse($('#attribute-list').text());
        attr_pass = []
        attr_list.forEach(function(attr){
            attr_pass[attr]  = false;
            pts_assigned = []
            validated = false
            $('.' + attr  + '-pts-assigned').change(function(){
                attr_list.forEach(function(changed_attr){
                    if ( attr == changed_attr ){
                        attr_pts_avail = $("#" + attr + "-pts-avail").text();
                        pts_assigned = []
                        $('.' + attr  + '-pts-assigned').each(function(i){
                            pts_assigned.push(parseInt($(this).val()));
                            skill_name = $(this).attr('name');
                            console.log(skill_name);
                            skill_pts_assigned = $('#'+skill_name+'-pts-assigned').html();
                            console.log(skill_pts_assigned);
                            skill_points_added = $(this).val();
                            skill_pts_total = parseInt(skill_pts_assigned) + parseInt($(this).val());
                            console.log(skill_pts_total);
                            console.log($('#'+skill_name+'-total').val())
                            $('#'+skill_name+'-total').val(skill_pts_total);
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
                            $('#validation-error').hide();
                            $('.btn-primary').prop('disabled', false);
                        }
                        else {
                            $('#validation-error').show();
                            $('.btn-primary').prop('disabled', true);
                        }
                    }
                });
            });
            
        });
        
    }
});