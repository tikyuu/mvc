#!bin/bash
if [ "$root_path" == "" ]; then
    readonly root_path="./app"
fi

# # # # # # # # # # # # # # # # # # # #
# delete controller,view
# $1 コントローラ名
# この関数で指定したコントローラとそれに関わるビューが全て消えるのでバージョン管理とかしといたほうがよい。
function delete()
{
    # 先頭のみ大文字に変換
    local controller="${1}"
    controller=${controller,,}
    controller=${controller^}

    # delete controller
    local controller_path="${root_path}/controllers/${controller}Controller.php"
    if [ -f "${controller_path}" ]; then
        rm -f "${controller_path}"
        echo "delete: ${controller_path}"
    fi

    # delete view
    local view_dir="${root_path}/views/templates/${controller}"
    if [ -d "${view_dir}" ]; then
        rm -rf ${view_dir}
        echo "delete: ${view_dir}"
    fi
}

# # # # # # # # # # # # # # # # # # # # #
# create controller,view
# $1 コントローラ名
# $2 アクション名 (デフォルトでindex)
function create()
{
    # args check
    if [ "${1}" == "" ]; then
        return
    fi
    local check_action="${2}"
    if [ "${check_action}" == "" ]; then
        check_action="index"
    fi

    # 先頭のみ大文字に変換
    local controller="${1}"
    controller=${controller,,}
    controller=${controller^}

    # 全て小文字に変換
    local action="${check_action}"
    action=${action,,}

    # create controller
    local controller_path="${root_path}/controllers/${controller}Controller.php"
    if [ -e "${controller_path}" ]; then
        echo "${controller_path}がすでに存在しています。"
        return
    fi
    echo "
<?php
class ${controller}Controller extends ControllerBase
{
    public function ${action}Action()
    {

    }
}
" >> "${controller_path}"

    # create view
    local view_path="${root_path}/views/templates/${controller}/${action}.tpl"
    local view_dir="${view_path%/*}"
    if [ ! -e "${view_dir}" ]; then
        mkdir ${view_dir}
    fi
    if [ -e "${view_path}" ]; then
        echo "${view_path}がすでに存在しています。"
        return
    fi
    echo "<h1>${controller}Controller - ${action}Action</h1>" >> "${view_path}"

    # success
    echo "success: ${controller}Controller - ${action}Action"
    echo "create: ${controller_path}"
    echo "create: ${view_path}"
    echo "check: 127.0.0.1/${controller}/${action}"
}

${1} ${2} ${3}