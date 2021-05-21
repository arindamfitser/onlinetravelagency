
<table class="table" id="order-listing">
    <thead class=" text-primary">
        <th>Hotel Id</th>
        <th>Hotel Name</th>
        <th>Image</th>
        <th>Action</th>
    </thead>
    <tbody>
        <?php
        if(!empty($hotels)):
            foreach($hotels as $h):
        ?>
            <tr>
                <td><?=$h->id?></td>
                <td><?=$h->name?></td>
                <td>
                    <?php if(!empty($h->image)): ?>
                    <img src="<?='https://www.stuba.com'.$h->image?>" style="height: 100px;" class="img-fluid" alt="<?=$h->name?>">
                    <?php endif; ?>
                </td>
                <td class="text-primary">
                    <a href="{{ route('admin.hotel.image.edit', [ 'id' => $h->id]) }}" title="Edit">
                        <i class="fa fa-edit"></i>
                    </a>
                </td>
            </tr>
        <?php
            endforeach;
        else:
        ?>
        <tr class="text-center"><td colspan="4">No Data Found</td></tr>
        <?php
        endif;
        ?>
    </tbody>
</table>