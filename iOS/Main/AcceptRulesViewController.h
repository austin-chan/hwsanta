//
//  WelcomeRulesViewController.h
//  HopingForAWish
//
//  Created by Austin Chan on 11/30/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface AcceptRulesViewController : UIViewController
@property (weak, nonatomic) IBOutlet UIButton *acceptButton;
@property (weak, nonatomic) IBOutlet UIButton *declineButton;
- (IBAction)rulesAccepted:(id)sender;
- (IBAction)rulesDeclined:(id)sender;

@end
