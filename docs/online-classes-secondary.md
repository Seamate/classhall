# Secondary Online Classes

The Online Classes catalogue includes Primary 1-6, JSS1-JSS3 and SS1-SS3
(Sciences students). Primary and JSS classes cost NGN 15,000 per calendar month;
SS1-SS3 Sciences cost NGN 25,000. All classes use
the existing manual renewal, payment confirmation and reminder flow.

## Subjects

- Primary: English, Mathematics and Science.
- Junior secondary: English, Mathematics and Intermediate Science.
- Senior secondary (science): English Language, General Mathematics,
  Biology, Chemistry and Physics.

## Reused timetable

All times are Nigeria time (WAT). Existing days and times are unchanged.
The Primary other-subject slot is now Science; the JSS slot is Intermediate Science.
The secondary year number selects one of the three existing timetable groups:

| Classes | First session | Second session | Other core subjects |
| --- | --- | --- | --- |
| JSS1 and SS1 | Monday 4:30-5:30 pm: Mathematics | Wednesday 4:30-5:30 pm: English | Thursday 4:30-5:30 pm |
| JSS2 and SS2 | Monday 5:30-6:30 pm: English | Tuesday 4:30-5:30 pm: Mathematics | Thursday 5:30-6:30 pm |
| JSS3 and SS3 | Tuesday 5:30-6:30 pm: English | Friday 4:30-5:30 pm: Mathematics | Wednesday 5:30-6:30 pm |

Senior-secondary session labels use English Language and General Mathematics.
The senior-secondary other-subject slot lists the remaining subjects together; this does not
allocate a separate weekly session to each of them. Staff must coordinate
teaching because primary, junior and senior classes share times and one room.

## Administration and deployment

Upload the updated kleo-child theme, including its inc and template-parts
folders, then clear page caches. No product recreation or database migration
is required. The existing virtual product and private class-key metadata are
retained. New enrolments store the generic Class label instead of Primary class.

WooCommerce > Online Classes shows all class timetables. Its Google Meet
setting controls the shared link for every level, including existing private
join links. Cron remains hourly, with 24-hour and 1-hour reminder jobs.

Before launch, check a secondary checkout and paid confirmation on staging.
Run `php tests/home-lesson-schedule-test.php` for isolated schedule, payment,
email and renewal regression coverage. This test sends no real emails.
