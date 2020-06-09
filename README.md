# aya

网站里的例子，供应商价格表列表的审核流程图相对复杂，一般正常情况下，供应链的审核流程不会这么复杂，这么做的原因主要是为了预防。



#### 介绍
一个简单的OA和ERP，作为学习中的一个实践，正在不断完善中。
个人时间原因，没有时间写详细的使用说明，见谅。
公司网管一名，在管理公司OA和ERP的过程中，由于公司情况复杂，很多需求供应商满足不了。所以尝试自己写一个玩玩。
水平有限，还有很多地方要优化，有兴趣的可以一起做。
不少思路都参考了公司OA（致远）和ERP（用友）的理念。

#### 在线演示地址


http://ayasv.com/demo/index.php


- 管理员账号包含了全部功能（除了个别流程）
- 管理员账号：admin
- 管理员密码: duoduo
- 用户账号：  010099
- 用户密码：  123

#### 备注
- 因为Thinkphp会写入日志文件，LINUX 服务器要修改 tp文件夹权限 
- 只支持火狐，谷歌，EDGE浏览器，因为测试都是在火狐上做的，暂时火狐上的效果最好
- 权限管理暂时没做，打算参考RBAC来做.
- 存货档案，供应商，客户中，我只列出了一些最常用的字段，有需要的可以自行添加.
- 流程管理还没完成，有很多地方需要优化。

#### 使用说明
1.修改数据库地址和密码
tp\config\database.php中修改

2.然后运行

gitee下载：http://YOURSERVE/index.php

github下载：：http://YOURSERVE/index.php

3.注意数据库文件可能有更新


QQ : 42686304