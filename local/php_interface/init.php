<?php

echo "Hello, world!";

AddEventHandler("main", "OnEndBufferContent", ['MyClass', 'myMethod']);
class MyClass
{
	function myMethod($content)
	{
		if ($_REQUEST['foo'] == 'bar') {
			str_replace('%FOO%', 'FOO', $content);
			str_replace('%BAR%', 'BAR', $content);
		}
	}
}