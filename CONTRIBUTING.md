I'm glad you are willing to contribute.. please adhere to the following:

- Before you make any pull request discuss about the change in a new Issue.
- Describe the current behaviour and explain which behavior you expect to see and the reason
- Explain why this changes will be useful to most users
- If you have changes on different features seperate them in different commits and pull requests.
- Make one feature change at a time.
- Share screenshots of your changes. it will speed up the review process
- Share the reason behind your changes.

## Features the software should have
* Roles : master, admin , teacher , student, accountant and librarian

* Registration

* **Academic sessions and semesters**

semesters has start and end dates. A semester has a status of 'open' or 'closed', if closed or if semester is not 'on-going' then some certain actions can't be performed for example, taking attendance. 

* **Classes and sections**

After creating a class, you have to create a section for this class (what others may call ARMS).
A class room does not exist for a class if this 'section' is not created.

* **Courses**

    ** courses are made per session , per semester , per class , per section.

    ** Once courses are added for a section, adding courses for the sections of the same class_id for subsequent semesters does not have to be a pain as the software will suggest these courses.

* **Attendance** 

    * Staff ( for all the workers in the school ) Attendace should be taken once daily during  the current semester, however room should be given for adjustment

    * daily attendance of the students hould be taken once daily during  the current semester however room should be given for adjustment
    
    * course attendance is taken by the teacher assigned to a particular course

* **Fees**

Fees should be made per session , per semester , per class , per section.

    These columns must be present in the Fees table
    * id
    * fee_name
    * amount
    * semester_id
    * section_id

* **Payment**

    * the student can choose to pay online in this case 'PAYSTACK' is used as payment gateway

    * the student can choose to pay in cash here the accountant handles the payment manually

    * of course the student should view payment receipt for any payment any time they want

* Accounts

* Library

* Notices and Events

* Syllabus

* Grade

* Exam
