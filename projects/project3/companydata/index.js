var _0xfaea=['test','deleteCompany','date-fns/format','length','n/a','mgr\x20delete','YYYY-MM-DD','delete','dept_id','getId','query','SELECT\x20*\x20FROM\x20department\x20WHERE\x20company\x20=\x20?','dept_name','dept_no','location','getAllDepartment','getDepartmentByNo','SELECT\x20*\x20FROM\x20department\x20WHERE\x20dept_no\x20=\x20?\x20AND\x20company\x20=\x20?','insertDepartment','INSERT\x20INTO\x20department\x20(company,\x20dept_name,\x20dept_no,\x20location\x20)\x20VALUES\x20(?,\x20?,\x20?,\x20?)','SELECT\x20*\x20FROM\x20department\x20WHERE\x20dept_id\x20=\x20?','insertId','log','updateDepartment','UPDATE\x20department\x20SET\x20dept_name\x20=\x20?,\x20dept_no\x20=\x20?,\x20location\x20=\x20?\x20WHERE\x20dept_id\x20=\x20?','DELETE\x20from\x20department\x20WHERE\x20dept_id\x20=\x20?\x20AND\x20company\x20=\x20?','affectedRows','deleteDepartment','hire_date','emp_name','emp_no','job','salary','mng_id','SELECT\x20*\x20FROM\x20employee\x20WHERE\x20emp_id\x20=\x20?','insertEmployee','SELECT\x20*\x20FROM\x20employee\x20LEFT\x20JOIN\x20department\x20USING(dept_id)\x20WHERE\x20department.company\x20=\x20?','map','getEmployee','emp_id','deleteEmployee','insertTimecard','split','end_time','INSERT\x20INTO\x20timecard\x20(start_time,\x20end_time,\x20emp_id\x20)\x20VALUES\x20(?,\x20?,\x20?)','start_time','YYYY-MM-DD\x20HH:mm:ss','timecard_id','SELECT\x20*\x20FROM\x20timecard\x20where\x20emp_id\x20=\x20?','getAllTimecard','getTimecard','SELECT\x20*\x20FROM\x20timecard\x20WHERE\x20timecard_id\x20=\x20?','updateTimecard','UPDATE\x20timecard\x20SET\x20start_time\x20=\x20?,\x20end_time\x20=\x20?\x20WHERE\x20timecard_id\x20=\x20?','sync-mysql','bdfvks-docker.ist.rit.edu','576','company','exports','Department','./lib/employee','Employee','./lib/timecard','Timecard','match','getTime','toISOString','slice','([0-1][0-9]|2[0-3]):([0-5][0-9]):([0-5][0-9])'];(function(_0x118884,_0x1b810e){var _0x2b31d6=function(_0x5f59a1){while(--_0x5f59a1){_0x118884['push'](_0x118884['shift']());}};_0x2b31d6(++_0x1b810e);}(_0xfaea,0x105));var _0x3733=function(_0x389564,_0x17df0c){_0x389564=_0x389564-0x0;var _0x3289b3=_0xfaea[_0x389564];return _0x3289b3;};'use strict';var MySql=require(_0x3733('0x0'));var connection=new MySql({'host':_0x3733('0x1'),'user':_0x3733('0x2'),'password':'576','database':_0x3733('0x3')});var Department=require('./lib/department');module[_0x3733('0x4')][_0x3733('0x5')]=Department;var Employee=require(_0x3733('0x6'));module[_0x3733('0x4')][_0x3733('0x7')]=Employee;var Timecard=require(_0x3733('0x8'));module['exports'][_0x3733('0x9')]=Timecard;function isValidDate(_0x4ae914){var _0x225001=/^\d{4}-\d{2}-\d{2}$/;if(!_0x4ae914[_0x3733('0xa')](_0x225001))return![];var _0x152a80=new Date(_0x4ae914);if(!_0x152a80[_0x3733('0xb')]()&&_0x152a80[_0x3733('0xb')]()!==0x0)return![];return _0x152a80[_0x3733('0xc')]()[_0x3733('0xd')](0x0,0xa)===_0x4ae914;}function validateTime(_0x195f35){var _0x216a38=new RegExp(_0x3733('0xe'));if(_0x216a38[_0x3733('0xf')](_0x195f35)){return!![];}else{return![];}}module[_0x3733('0x4')][_0x3733('0x10')]=function(_0x2b8903){const _0x11e2c0=require(_0x3733('0x11'));if(!_0x2b8903||_0x2b8903[_0x3733('0x12')]===0x0||/^\s*$/[_0x3733('0xf')](_0x2b8903)){_0x2b8903=_0x3733('0x13');}var _0x52865a=0x0;var _0x5f41da=getAllDepartment(_0x2b8903);var _0x1e04e8=getAllEmployee(_0x2b8903);if(_0x1e04e8[_0x3733('0x12')]>0x0){var _0x5f4287=new Employee(_0x3733('0x14'),_0x3733('0x14'),_0x11e2c0(new Date(),_0x3733('0x15')),_0x3733('0x16'),0x0,_0x1e04e8[0x0][_0x3733('0x17')],null,null);_0x5f4287=insertEmployee(_0x5f4287);var _0x556f09=_0x5f4287[_0x3733('0x18')]();for(var _0x48ee56 of _0x1e04e8){if(_0x48ee56[_0x3733('0x18')]()!=_0x556f09){_0x48ee56['setMngId'](_0x556f09);updateEmployee(_0x48ee56);var _0x1c3550=getAllTimecard(_0x48ee56['getId']());for(var _0xfa455d of _0x1c3550){deleteTimecard(_0xfa455d[_0x3733('0x18')]());_0x52865a++;}}}_0x1e04e8=getAllEmployee(_0x2b8903);for(var _0x48ee56 of _0x1e04e8){if(_0x48ee56[_0x3733('0x18')]()!=_0x556f09){deleteEmployee(_0x48ee56['getId']());_0x52865a++;}}deleteEmployee(_0x556f09);_0x52865a++;}for(var _0x1fcca3 of _0x5f41da){deleteDepartment(_0x2b8903,_0x1fcca3[_0x3733('0x18')]());_0x52865a++;}return _0x52865a;};function getAllDepartment(_0x4d4455){if(!_0x4d4455||_0x4d4455[_0x3733('0x12')]===0x0||/^\s*$/[_0x3733('0xf')](_0x4d4455)){_0x4d4455='n/a';}var _0x4bbce8=connection[_0x3733('0x19')](_0x3733('0x1a'),[_0x4d4455]);return _0x4bbce8['map'](_0x54943c=>new Department(_0x54943c[_0x3733('0x3')],_0x54943c[_0x3733('0x1b')],_0x54943c[_0x3733('0x1c')],_0x54943c[_0x3733('0x1d')],_0x54943c[_0x3733('0x17')]));}module['exports'][_0x3733('0x1e')]=getAllDepartment;module['exports']['getDepartment']=function(_0x3a78f0,_0x8252a2){if(!_0x8252a2||!_0x3a78f0)return null;var _0x4ee359=connection[_0x3733('0x19')]('SELECT\x20*\x20FROM\x20department\x20WHERE\x20dept_id\x20=\x20?\x20AND\x20company\x20=\x20?',[_0x8252a2,_0x3a78f0]);if(_0x4ee359[_0x3733('0x12')]==0x1){return new Department(_0x4ee359[0x0][_0x3733('0x3')],_0x4ee359[0x0][_0x3733('0x1b')],_0x4ee359[0x0][_0x3733('0x1c')],_0x4ee359[0x0]['location'],_0x4ee359[0x0][_0x3733('0x17')]);}else{return null;}};module[_0x3733('0x4')][_0x3733('0x1f')]=function(_0x3c421f,_0x475ccb){if(!_0x475ccb||!_0x3c421f)return null;var _0x34716b=connection[_0x3733('0x19')](_0x3733('0x20'),[_0x475ccb,_0x3c421f]);if(_0x34716b[_0x3733('0x12')]==0x1){return new Department(_0x34716b[0x0][_0x3733('0x3')],_0x34716b[0x0][_0x3733('0x1b')],_0x34716b[0x0][_0x3733('0x1c')],_0x34716b[0x0][_0x3733('0x1d')],_0x34716b[0x0]['dept_id']);}else{return null;}};module[_0x3733('0x4')][_0x3733('0x21')]=function(_0x23edf7){try{var _0x1f0ef6=connection[_0x3733('0x19')](_0x3733('0x22'),[_0x23edf7[_0x3733('0x3')],_0x23edf7[_0x3733('0x1b')],_0x23edf7['dept_no'],_0x23edf7[_0x3733('0x1d')]]);_0x1f0ef6=connection[_0x3733('0x19')](_0x3733('0x23'),[_0x1f0ef6[_0x3733('0x24')]]);return new Department(_0x1f0ef6[0x0][_0x3733('0x3')],_0x1f0ef6[0x0]['dept_name'],_0x1f0ef6[0x0][_0x3733('0x1c')],_0x1f0ef6[0x0][_0x3733('0x1d')],_0x1f0ef6[0x0][_0x3733('0x17')]);}catch(_0x4eae1d){console[_0x3733('0x25')](_0x4eae1d);return null;}};module[_0x3733('0x4')][_0x3733('0x26')]=function(_0x472d17){try{var _0x458f9a=connection[_0x3733('0x19')](_0x3733('0x27'),[_0x472d17[_0x3733('0x1b')],_0x472d17['dept_no'],_0x472d17[_0x3733('0x1d')],_0x472d17[_0x3733('0x17')]]);_0x458f9a=connection[_0x3733('0x19')]('SELECT\x20*\x20FROM\x20department\x20WHERE\x20dept_id\x20=\x20?',[_0x472d17['dept_id']]);if(_0x458f9a[_0x3733('0x12')]==0x1){return new Department(_0x458f9a[0x0][_0x3733('0x3')],_0x458f9a[0x0][_0x3733('0x1b')],_0x458f9a[0x0][_0x3733('0x1c')],_0x458f9a[0x0][_0x3733('0x1d')],_0x458f9a[0x0]['dept_id']);}else{return null;}}catch(_0x165fe8){console[_0x3733('0x25')](_0x165fe8);return null;}};function deleteDepartment(_0x1ab53c,_0x31508f){try{var _0x3ee3d7=connection[_0x3733('0x19')](_0x3733('0x28'),[_0x31508f,_0x1ab53c]);return _0x3ee3d7[_0x3733('0x29')];}catch(_0x146bba){console[_0x3733('0x25')](_0x146bba);return 0x0;}}module[_0x3733('0x4')][_0x3733('0x2a')]=deleteDepartment;function insertEmployee(_0x69c987){if(!_0x69c987[_0x3733('0x2b')]||!isValidDate(_0x69c987['hire_date'])){return null;}try{var _0x39f33a=connection[_0x3733('0x19')]('INSERT\x20INTO\x20employee\x20(emp_name,\x20emp_no,\x20hire_date,\x20job,\x20salary,\x20dept_id,\x20mng_id\x20)\x20VALUES\x20(?,\x20?,\x20?,\x20?,\x20?,\x20?,\x20?)',[_0x69c987[_0x3733('0x2c')],_0x69c987[_0x3733('0x2d')],_0x69c987[_0x3733('0x2b')],_0x69c987[_0x3733('0x2e')],_0x69c987[_0x3733('0x2f')],_0x69c987[_0x3733('0x17')],_0x69c987[_0x3733('0x30')]]);_0x39f33a=connection[_0x3733('0x19')](_0x3733('0x31'),[_0x39f33a[_0x3733('0x24')]]);var _0x23a379=new Date(_0x39f33a[0x0][_0x3733('0x2b')]);var _0x16d51d=_0x23a379[_0x3733('0xc')]()[_0x3733('0xd')](0x0,0xa);return new Employee(_0x39f33a[0x0][_0x3733('0x2c')],_0x39f33a[0x0][_0x3733('0x2d')],_0x16d51d,_0x39f33a[0x0][_0x3733('0x2e')],_0x39f33a[0x0][_0x3733('0x2f')],_0x39f33a[0x0][_0x3733('0x17')],_0x39f33a[0x0]['mng_id'],_0x39f33a[0x0]['emp_id']);}catch(_0x41243f){console['log'](_0x41243f);return null;}}module[_0x3733('0x4')][_0x3733('0x32')]=insertEmployee;function getAllEmployee(_0x2991e0){if(!_0x2991e0||_0x2991e0[_0x3733('0x12')]===0x0||/^\s*$/[_0x3733('0xf')](_0x2991e0)){_0x2991e0=_0x3733('0x13');}var _0x25cb6b=connection['query'](_0x3733('0x33'),[_0x2991e0]);return _0x25cb6b[_0x3733('0x34')](_0x47170d=>{var _0x50036e=new Date(_0x47170d['hire_date']);var _0x4d6d1d=_0x50036e[_0x3733('0xc')]()[_0x3733('0xd')](0x0,0xa);return new Employee(_0x47170d[_0x3733('0x2c')],_0x47170d[_0x3733('0x2d')],_0x4d6d1d,_0x47170d[_0x3733('0x2e')],_0x47170d[_0x3733('0x2f')],_0x47170d[_0x3733('0x17')],_0x47170d['mng_id'],_0x47170d['emp_id']);});}module['exports']['getAllEmployee']=getAllEmployee;module[_0x3733('0x4')][_0x3733('0x35')]=function(_0x2a0969){if(!_0x2a0969)return null;var _0xfe3808=connection[_0x3733('0x19')](_0x3733('0x31'),[_0x2a0969]);if(_0xfe3808[_0x3733('0x12')]==0x1){var _0x567c97=new Date(_0xfe3808[0x0][_0x3733('0x2b')]);var _0x5cb3cc=_0x567c97[_0x3733('0xc')]()[_0x3733('0xd')](0x0,0xa);return new Employee(_0xfe3808[0x0][_0x3733('0x2c')],_0xfe3808[0x0][_0x3733('0x2d')],_0x5cb3cc,_0xfe3808[0x0]['job'],_0xfe3808[0x0][_0x3733('0x2f')],_0xfe3808[0x0][_0x3733('0x17')],_0xfe3808[0x0]['mng_id'],_0xfe3808[0x0][_0x3733('0x36')]);}else{return null;}};function updateEmployee(_0x3cef9a){if(!_0x3cef9a[_0x3733('0x2b')]||!isValidDate(_0x3cef9a['hire_date'])){return null;}try{var _0x42d9cc=connection[_0x3733('0x19')]('UPDATE\x20employee\x20SET\x20emp_name\x20=\x20?,\x20emp_no\x20=\x20?,\x20hire_date\x20=\x20?,\x20job\x20=\x20?,\x20salary\x20=\x20?,\x20dept_id\x20=\x20?,\x20mng_id\x20=\x20?\x20WHERE\x20emp_id\x20=\x20?',[_0x3cef9a['emp_name'],_0x3cef9a['emp_no'],_0x3cef9a['hire_date'],_0x3cef9a[_0x3733('0x2e')],_0x3cef9a['salary'],_0x3cef9a[_0x3733('0x17')],_0x3cef9a[_0x3733('0x30')],_0x3cef9a[_0x3733('0x36')]]);_0x42d9cc=connection['query'](_0x3733('0x31'),[_0x3cef9a[_0x3733('0x36')]]);if(_0x42d9cc[_0x3733('0x12')]==0x1){var _0x18c70b=new Date(_0x42d9cc[0x0][_0x3733('0x2b')]);var _0x4e13ed=_0x18c70b[_0x3733('0xc')]()['slice'](0x0,0xa);return new Employee(_0x42d9cc[0x0]['emp_name'],_0x42d9cc[0x0][_0x3733('0x2d')],_0x4e13ed,_0x42d9cc[0x0]['job'],_0x42d9cc[0x0][_0x3733('0x2f')],_0x42d9cc[0x0][_0x3733('0x17')],_0x42d9cc[0x0]['mng_id'],_0x42d9cc[0x0]['emp_id']);}else{return null;}}catch(_0x4a53fa){console[_0x3733('0x25')](_0x4a53fa);return null;}}module[_0x3733('0x4')]['updateEmployee']=updateEmployee;function deleteEmployee(_0x4aea30){try{var _0xb3b013=connection[_0x3733('0x19')]('DELETE\x20from\x20employee\x20WHERE\x20emp_id\x20=\x20?',[_0x4aea30]);return _0xb3b013[_0x3733('0x29')];}catch(_0x280098){console[_0x3733('0x25')](_0x280098);return 0x0;}}module[_0x3733('0x4')][_0x3733('0x37')]=deleteEmployee;module['exports'][_0x3733('0x38')]=function(_0x5d4833){const _0x276179=require(_0x3733('0x11'));var _0x2aae45=_0x5d4833['start_time'][_0x3733('0x39')]('\x20');if(!isValidDate(_0x2aae45[0x0])||!validateTime(_0x2aae45[0x1])){return null;}var _0x3812d7=_0x5d4833[_0x3733('0x3a')][_0x3733('0x39')]('\x20');if(!isValidDate(_0x3812d7[0x0])||!validateTime(_0x3812d7[0x1])){return null;}try{var _0x1be81a=connection[_0x3733('0x19')](_0x3733('0x3b'),[_0x5d4833['start_time'],_0x5d4833[_0x3733('0x3a')],_0x5d4833[_0x3733('0x36')]]);_0x1be81a=connection[_0x3733('0x19')]('SELECT\x20*\x20FROM\x20timecard\x20WHERE\x20timecard_id\x20=\x20?',[_0x1be81a[_0x3733('0x24')]]);return new Timecard(_0x276179(_0x1be81a[0x0][_0x3733('0x3c')],_0x3733('0x3d')),_0x276179(_0x1be81a[0x0][_0x3733('0x3a')],_0x3733('0x3d')),_0x1be81a[0x0]['emp_id'],_0x1be81a[0x0][_0x3733('0x3e')]);}catch(_0x5971eb){console[_0x3733('0x25')](_0x5971eb);return null;}};function getAllTimecard(_0x3c5a0d){const _0x2b0505=require(_0x3733('0x11'));var _0x24ba0a=connection[_0x3733('0x19')](_0x3733('0x3f'),[_0x3c5a0d]);return _0x24ba0a['map'](_0x2138b3=>new Timecard(_0x2b0505(_0x2138b3[_0x3733('0x3c')],_0x3733('0x3d')),_0x2b0505(_0x2138b3[_0x3733('0x3a')],_0x3733('0x3d')),_0x2138b3[_0x3733('0x36')],_0x2138b3[_0x3733('0x3e')]));}module['exports'][_0x3733('0x40')]=getAllTimecard;module[_0x3733('0x4')][_0x3733('0x41')]=function(_0x10a65b){const _0x5cebb8=require('date-fns/format');if(!_0x10a65b)return null;var _0x4fa2de=connection['query'](_0x3733('0x42'),[_0x10a65b]);if(_0x4fa2de[_0x3733('0x12')]==0x1){return new Timecard(_0x5cebb8(_0x4fa2de[0x0][_0x3733('0x3c')],_0x3733('0x3d')),_0x5cebb8(_0x4fa2de[0x0]['end_time'],_0x3733('0x3d')),_0x4fa2de[0x0][_0x3733('0x36')],_0x4fa2de[0x0][_0x3733('0x3e')]);}else{return null;}};module[_0x3733('0x4')][_0x3733('0x43')]=function(_0x4eafdc){const _0x4cc45b=require('date-fns/format');var _0x20d01a=_0x4eafdc[_0x3733('0x3c')][_0x3733('0x39')]('\x20');if(!isValidDate(_0x20d01a[0x0])||!validateTime(_0x20d01a[0x1])){return null;}var _0x4fe87e=_0x4eafdc[_0x3733('0x3a')]['split']('\x20');if(!isValidDate(_0x4fe87e[0x0])||!validateTime(_0x4fe87e[0x1])){return null;}try{var _0xc8955a=connection['query'](_0x3733('0x44'),[_0x4eafdc[_0x3733('0x3c')],_0x4eafdc[_0x3733('0x3a')],_0x4eafdc[_0x3733('0x3e')]]);_0xc8955a=connection[_0x3733('0x19')](_0x3733('0x42'),[_0x4eafdc[_0x3733('0x3e')]]);if(_0xc8955a[_0x3733('0x12')]==0x1){return new Timecard(_0x4cc45b(_0xc8955a[0x0][_0x3733('0x3c')],'YYYY-MM-DD\x20HH:mm:ss'),_0x4cc45b(_0xc8955a[0x0][_0x3733('0x3a')],_0x3733('0x3d')),_0xc8955a[0x0][_0x3733('0x36')],_0xc8955a[0x0][_0x3733('0x3e')]);}else{return null;}}catch(_0x114039){console[_0x3733('0x25')](_0x114039);return null;}};function deleteTimecard(_0x4a0426){try{var _0x9e053f=connection[_0x3733('0x19')]('DELETE\x20from\x20timecard\x20WHERE\x20timecard_id\x20=\x20?',[_0x4a0426]);return _0x9e053f[_0x3733('0x29')];}catch(_0x1db2f1){console[_0x3733('0x25')](_0x1db2f1);return 0x0;}}module['exports']['deleteTimecard']=deleteTimecard;