-- trần khôi 1660281

CREATE DATABASE web2020
CHARACTER SET 'utf8' COLLATE 'utf8_unicode_ci';
USE web2020;
CREATE TABLE myuser(
	userID int AUTO_INCREMENT PRIMARY KEY,
    status int null,
	email varchar(255),
    password varchar(255),
    username varchar(255),
    fullname varchar(255),
    phonenumber varchar(255),
	avatar varchar(255),
	code varchar(255)
);

CREATE TABLE mypost(
	postID int AUTO_INCREMENT PRIMARY KEY,
	userID int,
	content text,
	timecreate datetime,
	privacy varchar(10) default 'public'	-- có 3 chế độ: private, friend, public
);
alter table mypost add foreign key(userID) references myuser(userID);

-- 1 bài post có nhiều hình ảnh
CREATE TABLE post_picture(
	pictureID int AUTO_INCREMENT PRIMARY KEY,
	postID int,
	picturePath varchar(255)
);
alter table post_picture add foreign key(postID) references mypost(postID);

CREATE TABLE friends(
	userIDSend int not null,	-- id người gửi lời kết bạn
	userIDRecive int not null,	-- id người nhận lời mời
	timecreate datetime, -- ngày gửi lời mời,  nếu đã chấp nhận thì sẽ là ngày làm bạn
	status bit default 0,	-- 1(đã chấp nhận), 0: chưa chấp nhận
	PRIMARY KEY (userIDSend, userIDRecive)
);
alter table friends add foreign key(userIDSend) references myuser(userID);
alter table friends add foreign key(userIDRecive) references myuser(userID);

CREATE TABLE follows(
	userID int not null,	-- người dùng
	follower int not null,	-- id người theo dõi người dùng đó
	timecreate datetime, 
	PRIMARY KEY (userID, follower)
);
alter table follows add foreign key(userID) references myuser(userID);
alter table follows add foreign key(follower) references myuser(userID);

CREATE TABLE likes(
	postID int,  	-- post mà người dùng like
	userID int, 	-- người like post đó
	timecreate datetime,
	PRIMARY key (postID, userID)
);
alter table likes add foreign key(userID) references myuser(userID);
alter table likes add foreign key(postID) references mypost(postID);

CREATE TABLE comments(
	commentID int AUTO_INCREMENT PRIMARY KEY,
	postID int,  -- post mà người dùng comment vào
	userID int, -- người comment
	content text,
	timecreate datetime
);
alter table comments add foreign key(userID) references myuser(userID);
alter table comments add foreign key(postID) references mypost(postID);


CREATE TABLE messages(
	messageID int AUTO_INCREMENT PRIMARY KEY,
	fromUserID int,  -- post mà người dùng comment vào
	toUserID int, -- người comment
	content text,
	timecreate datetime
);
alter table messages add foreign key(fromUserID) references myuser(userID);
alter table messages add foreign key(toUserID) references myuser(userID);

ALTER TABLE `messages` ADD `hasRead` VARCHAR(10) NOT NULL DEFAULT 'no' AFTER `timecreate`;
ALTER TABLE `messages` ADD `hasTake` VARCHAR(10) NOT NULL DEFAULT 'no' AFTER `hasRead`;