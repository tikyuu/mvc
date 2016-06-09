
root="/var/www/html/mvc/app"

function on()
{
  export mvc="${root}/../"
  export model="${root}/models"
  export view="${root}/views/templates"
  export controller="${root}/controllers"
  export util_log="${root}/../log/util.log"
}
function off()
{
  export -n mvc
  export -n model
  export -n view
  export -n controller
  export -n util_log
}


on
