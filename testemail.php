<?php

function purify_list($comma_sep_list1, $comma_sep_list2)
{

        $regex = '/[^0-9a-zA-Z\.\-_@,]+/';
        $emaillist1 = explode(",", preg_replace($regex, ',', trim($comma_sep_list1)));
        $emaillist2 = explode(",", preg_replace($regex, ',', trim($comma_sep_list2)));

        $purelist_array = array_unique(array_merge($emaillist1, $emaillist2));

        $purelist_array_cleaned = array_filter($purelist_array);
        $purelist = implode(',', $purelist_array_cleaned);

        return $purelist;
}



$a = <<<EOT
hjsgjhhj@jhiuh.com jndjknndjnsd@ni.dijid;jnidn@nju.com, jja@id.com
EOT;


$b = <<<EOT
jndjknndjnsd@ni.dijid;
EOT;

print_r(purify_list($a,$b));
