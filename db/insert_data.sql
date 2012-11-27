DELETE FROM department;
INSERT INTO department VALUES ('Computer Science');
INSERT INTO department VALUES ('Mathmetics');

DELETE FROM users;
INSERT INTO users VALUES ('admin@sju.edu', '7180fc5d71fe7867d04e95de59154bdb0fe2be71', 'Admin', NULL, 'Admin');
INSERT INTO users VALUES ('jz570129@sju.edu', '7180fc5d71fe7867d04e95de59154bdb0fe2be71', 'Jing Zhao', NULL, 'Student');
INSERT INTO users VALUES ('gz570130@sju.edu', '7180fc5d71fe7867d04e95de59154bdb0fe2be71', 'Guo Jun', NULL, 'TA');
INSERT INTO users VALUES ('tezel@sju.edu', '7c6a61c68ef8b9b6b061b28c348bc1ed7921cb53', 'Dr. Suzan Koknar-Tezel', NULL, 'Professor');
INSERT INTO users VALUES ('bforouraghi@sju.edu', '7c6a61c68ef8b9b6b061b28c348bc1ed7921cb53', 'Dr. Babak Forouraghi', NULL, 'Professor');
INSERT INTO users VALUES ('ggrevera@sju.edu', '7c6a61c68ef8b9b6b061b28c348bc1ed7921cb53', 'Dr. George Grevera', NULL, 'Professor');
INSERT INTO users VALUES ('fatalay@sju.edu', '7c6a61c68ef8b9b6b061b28c348bc1ed7921cb53', 'Dr. Atalay ', NULL, 'Professor');
INSERT INTO users VALUES ('swei@sju.edu', '7c6a61c68ef8b9b6b061b28c348bc1ed7921cb53', 'Dr. Susanna Wei ', NULL, 'Professor');

DELETE FROM course;
INSERT INTO course VALUES (NULL, 'image/courses/CSS626 Web Technologies/computer_network.png', 'CSS626 Web Technologies', 'Topics include organization of Meta-Markup languages, Document Type Definitions (DTDs), document validity and well-formedness, style languages, namespaces, Transformations, XML parsers, Web Services, and Web Security Specifications. Course includes programming projects.', 'bforouraghi@sju.edu', 'Computer Science', '2012Fall');
INSERT INTO course VALUES (NULL, 'image/courses/CSC 550 Objected Oriented and Data Structure/data_structure.png', 'CSC 550 Objected Oriented and Data Structure', 'Data structure', 'tezel@sju.edu', 'Computer Science', '2012Fall');
INSERT INTO course VALUES (NULL, 'image/courses/Computer Science I/programming_language.png', 'Computer Science I', 'Java I', 'swei@sju.edu', 'Computer Science', '2012Fall');
INSERT INTO course VALUES (NULL, 'image/courses/Computer Science II/computer_science.png', 'Computer Science II', 'Java II', 'swei@sju.edu', 'Computer Science', '2012Fall');
INSERT INTO course VALUES (NULL, 'image/courses/Computer Vision/computer_vision.png', 'Computer Vision', 'vision', 'ggrevera@sju.edu', 'Computer Science', '2012Fall');
INSERT INTO course VALUES (NULL, 'image/courses/Machine Learning/machine_learning.png', 'Machine Learning', 'Machine learning and Artifical Intellegence', 'bforouraghi@sju.edu', 'Computer Science', '2012Fall');
INSERT INTO course VALUES (NULL, 'image/courses/Network Security/cryptography.png', 'Network Security', 'Network Security and Cryptography', 'bforouraghi@sju.edu', 'Computer Science', '2012Fall');
INSERT INTO course VALUES (NULL, 'image/courses/Internet Application Development/IADcourseimage.png', 'Internet Application Development', 'This course will attempt to give you experience in designing Internet applications. A student finishing this course should be able to design, implement, and maintain a large community or e-commerce web site. They should leave the course with an understanding of a variety of Internet protocols and markup languages, a knowledge of at least one common scripting tool, an understanding of how to implement a database back-end into a large-scale site, and the ability to critically assess the usability of both their design and the design of others.', 'bforouraghi@sju.edu', 'Computer Science', '2012Fall');


DELETE FROM groups;
INSERT INTO groups VALUES('Group_1', 1, NULL);
INSERT INTO groups VALUES('Group_2', 1, NULL);
INSERT INTO groups VALUES('Group_1', 2, NULL);
INSERT INTO groups VALUES('Group_2', 2, NULL);
INSERT INTO groups VALUES('Group_3', 2, NULL);
INSERT INTO groups VALUES('Group_1', 3, NULL);
INSERT INTO groups VALUES('Group_2', 3, NULL);

DELETE FROM usercourses;
INSERT INTO usercourses VALUES('jz570129@sju.edu', 1, 'Student', 'Group_1');
INSERT INTO usercourses VALUES('jz570129@sju.edu', 2, 'Student', 'Group_2');
INSERT INTO usercourses VALUES('jz570129@sju.edu', 3, 'TA', 'Group_2');
INSERT INTO usercourses VALUES('gz570130@sju.edu', 1, 'Student', 'Group_1');
INSERT INTO usercourses VALUES('bforouraghi@sju.edu', 1, 'Instructor', NULL);
INSERT INTO usercourses VALUES('bforouraghi@sju.edu', 6, 'Instructor', NULL);
INSERT INTO usercourses VALUES('bforouraghi@sju.edu', 7, 'Instructor', NULL);
INSERT INTO usercourses VALUES('tezel@sju.edu', 2, 'Instructor', NULL);
INSERT INTO usercourses VALUES('swei@sju.edu', 3, 'Instructor', NULL);
INSERT INTO usercourses VALUES('swei@sju.edu', 4, 'Instructor', NULL);
INSERT INTO usercourses VALUES('swei@sju.edu', 1, 'Student', 'Group_1');
INSERT INTO usercourses VALUES('ggrevera@sju.edu', 5, 'Instructor', NULL);


DELETE FROM assignment;
INSERT INTO assignment VALUES(NULL, 1, 'XML DTD', 'Writer DTD rules for given XML and write XML which is validated by the given DTD', "/image/assignments/1/proj1.html", NOW(), '2012-08-06', 'Group');
INSERT INTO assignment VALUES(NULL, 1, 'Parse XML', 'Parse XML using SAX and DOM test test test test test test test test test test test test test test test test test test test test test test test test test test test test tqreqrqest test test test test test test test test test testqewrqe test test test test test erqherqeroq  test test test test test test test test tesqerq vsfsdfwre t tfaferklk estdaf  sdfweftsdf fadfa dfadf afadfaest test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test test', "/image/assignments/1/proj2.html", NOW(), '2012-08-10', 'Individual');
INSERT INTO assignment VALUES(NULL, 1, 'XSLT', 'Parse the given XML into HTML using XSLT', "/image/assignments/1/proj3.html", NOW(), '2012-08-10', 'Individual');
INSERT INTO assignment VALUES(NULL, 3, 'Dynamic programming   mathematics mathematics mathematics mathematics mathematics', 'Dynamic programming', NULL, NOW(), '2012-08-10', 'Group');

DELETE FROM coursecontent;
INSERT INTO coursecontent VALUES('HTML', 'HTML document structure, list, table, form, image', 'image/courses/Internet Application Development/HTML/HTML.ppt', 8);
INSERT INTO coursecontent VALUES('HTML', 'XML, DTD, XML schema', 'image/courses/Internet Application Development/HTML/xml.ppt', 8);
INSERT INTO coursecontent VALUES('Javascript', 'Basic javascript', 'image/courses/Internet Application Development/Javascript/javascript_1.ppt',8);
INSERT INTO coursecontent VALUES('Javascript', 'Advanced javascript', 'image/courses/Internet Application Development/Javascript/javascript_2.ppt',8);
INSERT INTO coursecontent VALUES('Javascript', 'Ajax', 'image/courses/Internet Application Development/Javascjavascript_3ript/.ppt',8);

DELETE FROM submission;
INSERT INTO submission VALUES(NULL, 1, 'Group_1', NOW(), NULL);
INSERT INTO submission VALUES(NULL, 1, 'Group_2', NOW(), NULL);
INSERT INTO submission VALUES(NULL, 2, 'jz570129@sju.edu', NOW(), NULL);
INSERT INTO submission VALUES(NULL, 2, 'gz570130@sju.edu', NOW(), NULL);
INSERT INTO submission VALUES(NULL, 2, 'swei@sju.edu', NOW(), NULL);
INSERT INTO submission VALUES(NULL, 3, 'Group_1', NOW(), NULL);
INSERT INTO submission VALUES(NULL, 3, 'Group_2', NOW(), NULL);
INSERT INTO submission VALUES(NULL, 4, 'Group_1', NOW(), NULL);
INSERT INTO submission VALUES(NULL, 4, 'Group_2', NOW(), NULL);

DELETE FROM comments;
--INSERT INTO comments VALUES('Unexpected token !', 'Remove the token', 1, 'functionality', '../image/submissions/1/1/1_1_Group_1/JZHW1/prob2.dtd', 16, 'gz570130@sju.edu');
--INSERT INTO comments VALUES('incorrect keyword NMTOKEN', 'Change it to TOKEN', 2, 'functionality', '../image/submissions/1/1/1_1_Group_1/JZHW1/prob2.dtd', 20, 'jz570129@sju.edu');


