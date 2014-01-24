#!/usr/bin/python

import os
import sys

from launchpadlib.launchpad import Launchpad

cachedir = os.path.expanduser("~/.launchpadlib/cache/")
launchpad = Launchpad.login_anonymously('just testing', 'production',
                                        cachedir)

args = sys.argv[1:]

statuses=['Work in progress', 'Approved', 'Needs review', 'Rejected',
          'Merged', 'Code failed to merge', 'Queued', 'Superseded']

if len(args) > 2:
    dist = launchpad.distributions[args[0]]
    project = dist.getSourcePackage(name=args[1])
    merge_id = args[2]
else:
    project = launchpad.projects[args[0]]
    merge_id = args[1]

proposals = project.getMergeProposals(status=statuses)

result = None
for prop in proposals:
    url = prop.web_link
    prop_merge_id = os.path.basename(url)
    if merge_id == prop_merge_id:
        print url
        break
