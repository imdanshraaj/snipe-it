<?php

return array(

    'does_not_exist' => '[;id] อุปกรณ์เสริม ไม่มีอยู่',
    'not_found' => 'That accessory was not found.',
    'assoc_users'	 => 'อุปกรณ์เสริมนี้ได้เช็คเอ้าท์ให้ผู้ใช้งานแล้วจำนวน :count รายการในปัจจุบัน กรุณาเช็คอินอุปกรณ์เสริม และลองอีกครั้ง ',

    'create' => array(
        'error'   => 'อุปกรณ์เสริมยังไม่ได้ถูกสร้าง กรุณาลองใหม่อีกครั้ง',
        'success' => 'อุปกรณ์เสริมได้ถูกสร้างเรียบร้อยแล้ว'
    ),

    'update' => array(
        'error'   => 'ยังไม่ได้แก้ไขอุปกรณ์เสริม กรุณาลองใหม่',
        'success' => 'แก้ไขอุปกรณ์เสริมสำเร็จ'
    ),

    'delete' => array(
        'confirm'   => 'คุณแน่ใจที่จะลบอุปกรณ์เสริมนี้?',
        'error'   => 'มีปัญหาขณะลบอุปกรณ์เสริมนี้ กรุณาลองอีกครั้ง.',
        'success' => 'ลบอุปกรณ์เสริมเรียบร้อยแล้ว'
    ),

     'checkout' => array(
        'error'   		=> 'อุปกรณ์เสริมยังไม่ถูกเช็คเอ้าท์ กรุณาลองอีกครั้ง',
        'success' 		=> 'อุปกรณ์เสริมเช็คเอ้าท์เรียบร้อยแล้ว',
        'unavailable'   => 'Accessory is not available for checkout. Check quantity available',
        'user_does_not_exist' => 'ผู้ใช้งานไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง',
         'checkout_qty' => array(
            'lte'  => 'There is currently only one available accessory of this type, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.|There are :number_currently_remaining total available accessories, and you are trying to check out :checkout_qty. Please adjust the checkout quantity or the total stock of this accessory and try again.',
            ),
           
    ),

    'checkin' => array(
        'error'   		=> 'อุปกรณ์เสริมยังไม่ถูกเช็คอิน กรุณาลองอีกครั้ง',
        'success' 		=> 'อุปกรณ์เสริมเช็คอินเรียบร้อยแล้ว.',
        'user_does_not_exist' => 'ผู้ใช้งานไม่ถูกต้อง กรุณาลองใหม่อีกครั้ง.'
    )


);
