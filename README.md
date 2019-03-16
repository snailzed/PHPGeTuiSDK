## 个推php SDK自动加载
>现在几乎所有PHP项目都是使用`composer`来管理，但个推官方提供的SDK只能`require`或者`include`到项目中，这对使用composer自动加载的项目非常不友好，故干了下体力活，使用`composer`来加载个推SDK，引入了`namespace`。


## 使用方式
   
    composer require snailzed/php-getui
