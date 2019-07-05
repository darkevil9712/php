$(document).ready(()=>{
    initLayout();
    initEvent();
})

const initLayout = () =>{
    var datatable = webix.ui({
        view:"datatable",
        id: "tbChucVu",
        container: "tbChucVu",
        autowidth:true,
        autoheight: true,
        select:"row",
        multiselect:true,
        columns:[
            { id:"id",    header:"Mã chức vụ",      width:50},
            { id:"name",   header:"Tên chức vụ",    width:200, editor:"text"},

        ],
        data: []
    });

    $$('tbChucVu').attachEvent("onItemDblClick", function(id, e, node){
        let data = $$('tbChucVu').getSelectedItem();
        openPopup(data);
    });
}

const initEvent = () =>{
    $('#btnSearch').click(()=>{
        getData();
    });
    
    $('#btnAdd').click(()=>{
        openPopup();
    });

    $('#btnDelete').click(()=>{
        deleteData();
    });


}

function getData() {
    $$('tbChucVu').clearAll();
    webix.ajax().get("Controller/LoadAll.php").then(function(data){
        $$('tbChucVu').parse(JSON.parse(data.text()));
    });
}

function openPopup(data) {
    var popup = webix.ui({
        view:"popup",
        id:"my_popup",
        height:250,
        position:"center",
        width:500,
        body:{
            id: "frmAdd",
            view:"form",
            elements:[
                { view:"text", id: "txtId", name: "txtId", labelWidth: 150, label:"Mã chức vụ"},
                { view:"text", id: "txtChucVu", name: "txtChucVu", labelWidth: 150, label:"Tên chức vụ" },
                { view:"text", id: "txtFlg", name: "txtFlg", value: 'I', hidden: true},
                {cols:[
                    {
                        view:"button", id:"btnAddNew", value:"Add New", css:"webix_primary" ,
                    },
                    {
                        view:"button", id:"btnCancel",value:"Cancel"
                    }
                ]}
            ]
        }
    }).show();

    if(data != null){
        $$("frmAdd").setValues({
            txtId: data.id,
            txtChucVu: data.name,
            txtFlg: 'U'
        });
    }

    $$('btnAddNew').attachEvent("onItemClick", function(id, e){
        var name = $$('txtChucVu').data.value;
        var id = parseInt($$('txtId').data.value);
        var flg = $$('txtFlg').data.value;
        $.ajax({
            url : "controller/modify.php",
            type : "post",
            dataType:"text",
            data : {
                name : name,
                id: id,
                flg: flg
            },
            success : function (data){
                var result = data;
                if(result == 'D'){
                    webix.alert({
                        title:"Duplicated",
                        ok:"Close",
                        text: "Duplicated"
                    })
                }
                else if(data >= 1){
                    $$('my_popup').close();
                    getData();
                    webix.alert({
                        title:"successed",
                        ok:"Close",
                        text: "Successed"
                    })
                }

            },
            error: function (err) {
                console.log(err);
            }
        })
    });
}

function deleteData(){
    let data = $$('tbChucVu').getSelectedItem();
    processDeleteData(data);
}

function processDeleteData(del){
    $.ajax({
        url : "controller/modify.php",
        type : "post",
        dataType:"json",
        data : {
            arrChucVu: JSON.stringify(del),
            flg: 'D'
        },
        success : function (data){
            if(data >= 1){
                getData();
                webix.alert({
                    title:"Deleted successed",
                    ok:"Close",
                    text: "Successed"
                })
            }

        },
        error: function (err) {
            console.log(err);
        }
    })
}
