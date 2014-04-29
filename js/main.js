
function checkAll()
{
	all_checkbox = document.getElementById("all");
	
	all_elements = document.getElementsByClassName("checkbox");
	for (var i = 0; i < all_elements.length; i++)
	{
		if(all_checkbox.checked == true)
		{			
			all_elements[i].checked = true;
		}
		else
		{
			all_elements[i].checked = false;
		}
	}
}
function initialize()
{
	document.getElementById("all").addEventListener("click", checkAll, false);
}

document.addEventListener("DOMContentLoaded", initialize, false);