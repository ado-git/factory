<%@taglib uri="http://java.sun.com/jsp/jstl/core" prefix="c" %>


<?php foreach($atributos as $var): ?>
<div>${<?php echo $var;?>}</div>
<?php endforeach; ?>

<c:forEach var="v" items="${<?php echo $atributo_listado;?>}">
<table><tr><td>${v}</td><td><a href="">${v}</a></td></tr></table>
</c:forEach>