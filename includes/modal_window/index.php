<!--���� ����������� web-������� roothelp.ru--><!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"><html><head><title>��������� ���� | JavaScript</title><link rel="stylesheet" type="text/css" href="style.css"/></head><body><table class='width onetable'><tr><td><a href='http://www.roothelp.ru'><img class='roothelp_img' src='http://www.roothelp.ru/logo.png'/></a></td><td><p class='rh_webstudia'>���� ����������� web-������� roothelp.ru, ���������� �� ��������!</p><p class='rh_title'>��������� ���� | JavaScript</p></td></tr></table><div class='center'><br><table class='width'><tr><td valign='top'><div class="text"><script>//�������� ��������� �� id "a" � "b"window.onload = function(){a = document.getElementById("a");b = document.getElementById("b");} //���������� ���� ������� "showA"function showA(){//������ ������������ � ��������� �������//�������� "b"b.style.filter = "alpha(opacity=80)";b.style.opacity = 0.8;b.style.display = "block";// ������ ����������� � ������ ������ � 200px//�������� "a"a.style.display = "block";a.style.top = "200px";}//�������� ������� "hideA", ������� ����� �������� ����//��� ��������� "a" � "b"function hideA(){b.style.display = "none";a.style.display = "none";}      </script><a href="#" onclick="showA();" class="pages">�������</a><div id="a"><div id="windows"><!-- ��� ����� --><a href="#" onclick="hideA();" class="pages" style="float: right;">�������</a></div></div><div id="b"></div></div></td></tr></table></div></body></html>