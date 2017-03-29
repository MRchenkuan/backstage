/**
 * Created by chenkuan on 2016/12/23.
 */
'use strict';
function API(urlHost){
    this.urlHost = urlHost;
}

API.fn = API.prototype = {};

/**
 * post工具
 * @param url 接口地址
 * @param param 请求参数
 * @param fn 成功回调
 * @param completed 完成回调
 * @param err 错误回调
 * @param failed 失败回调
 */
API.fn.post = function(url,param,fn,completed,err,failed){
    $.ajax({
        url: this.urlHost + url,
        type: "post",
        success: function(data){
             fn(data)
        },
        error:function(data){
            if(failed){
                failed(data)
            }else{
                throw data;
            }
        },
        completed:function(data){
            if(completed){
                completed(data)
            }
        },
        data: JSON.stringify(param),
        //dataType: 'jsonp',
        xhrFields: {
            withCredentials: true
        },
        crossDomain: true,
        contentType: "application/json"
    });
};


// // 测试环境
var api = new API("http://teamsupport.sqbj.com:8051/ifsys/");

// // // 线上环境
// var api = new API("../");