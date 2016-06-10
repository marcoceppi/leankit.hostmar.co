# Leankit URL director-thing

Leankit's cool, and it has this URL card magic. So this allows you to support multiple external bug trackers via `<protocol>:<info>`

## Supported trackers

### Github

Use `gh:<user>/<repo>/<issue>` to link to either a merge request or a Github bug for that repo.

Use `gh:<user>/<repo>/tree/<branch>` to link to a branch.

### LaunchPad

Use `lp:<bug-number>` to link to a LaunchPad bug.

Use `lp:<project>/<merge-id>` to get a merge proposal for that project

Use `lp:<distro>/<source>/<merge-id>` to link to a merge proposal for a source package in a distro (hint, charms is a distro)

### CodeReview

Use `cr:<request>` to link to a CodeReview on http://codereview.appspot.com
