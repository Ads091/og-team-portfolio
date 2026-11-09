CAPSTONE TEAM PORTFOLIO — VERSION 3.0.3

WHAT'S NEW IN 3.0
- New editorial design: Instrument Serif headlines, ruled grids, warm paper tones and a single cobalt accent.
- Dark mode is the default; visitors can switch to light mode and their choice is remembered.
- Team members are shown as an index list with portraits that move from grayscale to colour on hover.
- A scrolling ticker shows every skill saved on published team members.
- Project cards share one template part (template-parts/project-card.php) on the homepage and the Projects archive.
- The team name "OG Team Portfolio" is set by the theme (Customize > Capstone Portfolio Homepage > Team name) and no longer comes from the WordPress Site Title.
- Fonts load from Google Fonts (Instrument Serif, Hanken Grotesk, JetBrains Mono).
- All content types, settings, the contact form and email routing work exactly as in 2.0.

PREVIOUSLY IN 2.0
- Dark-first responsive portfolio design with a saved dark/light mode switch.
- Existing Team Members content type and profile URLs are retained.
- Team member details now include a private contact email used only for message routing.
- New Projects content type with filterable Project Categories, year, and optional external URL.
- Homepage statistics are calculated from published members, projects, and saved skills.
- Contact page form supports team-wide and individual-member inquiries.
- Individual inquiries go to the selected member's saved email; if no valid member email is saved, the message goes to the team inbox.
- Contact form includes nonce validation, server-side validation, a honeypot field, and WordPress wp_mail delivery.
- Dashboard overview widget and useful Team Members / Projects admin columns.
- CG monogram is used as the default theme logo when no WordPress Custom Logo is set.

INSTALLATION
1. Back up your website files and database before changing themes.
2. In WordPress, go to Appearance > Themes > Add New > Upload Theme.
3. Select capstone-team-portfolio-v2.zip and click Install Now.
4. Activate the theme.
5. Existing pages, posts, Team Members, media, menus, and theme settings are not intentionally deleted or reset.
6. Go to Settings > Permalinks and click Save Changes once if the new Projects archive returns a 404.

TEAM CONTACT ROUTING
1. Go to Appearance > Customize > Capstone Portfolio Homepage.
2. Set Contact email to the official team inbox. If it is blank or invalid, WordPress falls back to the site administrator email.
3. Go to Team Members and edit each member. Enter their Contact email in the Member Details panel.
4. Member email addresses are stored privately and are not displayed in public profile pages or the contact form.
5. A contact form submission for a member with no valid email is sent to the team inbox.

PROJECT MANAGEMENT
1. Go to Projects > Add New.
2. Add a project title, summary, full description, featured image, category, year, and optional external URL.
3. Publish the project. It will appear automatically in the homepage project section and the Projects archive.
4. Project category filters work on the homepage and Projects archive.

CUSTOMIZE THE HOMEPAGE
Go to Appearance > Customize > Capstone Portfolio Homepage to update the hero eyebrow, headline, description, featured project title and description, and team contact email.

EMAIL DELIVERY
The contact form uses WordPress wp_mail(). Configure and test your SMTP plugin or hosting mail service before publishing. This theme does not send messages through a third-party service or expose recipient email addresses in the browser.

NOTES
- The original Team Members post type, member rewrite slug (team-member), existing role/skills/order metadata, homepage Customizer settings, and existing pages are retained.
- No sample projects or fabricated statistics are inserted. Statistics reflect actual published content.
- Existing WordPress plugins and WordPress core are not included in this theme ZIP and are not modified.
- Replace starter names and descriptions before public launch.
- Use a valid SSL-enabled domain and a working SMTP configuration before public launch.
