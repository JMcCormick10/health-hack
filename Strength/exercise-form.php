<?php
/**
 * Created by PhpStorm.
 * User: JoshMcCormick
 * Date: 2017-03-28
 * Time: 9:41 AM
 */

?>
<?php  foreach ($strength_Workout as $key) :?>
    <tr><input type="hidden" name="exercise_id[]" value="<?php echo $key['exercise_id'];?>"/>
        <input type="hidden" name="strength_id[]" value="<?php echo $key['strength_id'];?>"/>
        <input type="hidden" name="exercise_name[]" value="<?php echo $key['exercise_name']?>"/>
        <td><?php echo $key['exercise_name'];?></td>
        <td><select name="weight[]">
                <?php
                foreach (range(0, 200, 5) as $i):
                    ?>
                    <option
                        value="<?php
                        echo $i;
                        ?>"><?php
                        echo $i;
                        ?></option>
                <?php endforeach;
                ?>
                <option value="1">No Weight</option>
            </select>
        </td>
        <td><select name="set_1[]">
                <?php foreach (range(0, 15, 1) as $i):?>
                    <option value="<?php echo $i;?>"><?php echo $i;?></option><?php endforeach;?>
            </select>
        </td>
        <td><select name="set_2[]">
                <?php foreach (range(0, 15, 1) as $i):?>
                    <option value="<?php echo $i;?>"><?php echo $i;?></option><?php endforeach;?>
            </select>
        </td>
        <td><select name="set_3[]">
                <?php foreach (range(0, 15, 1) as $i):?>
                    <option value="<?php echo $i;?>"><?php echo $i;?></option><?php endforeach;?>
            </select>

        </td>
    </tr>


<?php  endforeach;?>
