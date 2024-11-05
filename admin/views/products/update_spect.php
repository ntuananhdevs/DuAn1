<h3 class="mb-0 h4 font-weight-bolder mb-4">Edit Spect</h3>
<form action="">

</form>
<div class="container">
<form action="?act=post_update_spect" method="post" enctype="multipart/form-data">
    <table class="table">
        <tbody>
            <?php foreach ($list_spect as $index => $spec) : ?>
                <tr class="<?php echo $index % 2 == 0 ? 'bg-light' : ''; ?>">
                    <td class="font-weight-bold" style="width: 20%;">
                        <input type="text" name="specifications[<?php echo $index; ?>][Specification_Name]" 
                               value="<?php echo htmlspecialchars($spec['Specification_Name']); ?>" 
                               class="form-control">
                    </td>
                    <td>
                        <input type="text" name="specifications[<?php echo $index; ?>][Specification_Value]" 
                               value="<?php echo htmlspecialchars($spec['Specification_Value']); ?>" 
                               class="form-control">
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>

</div>
