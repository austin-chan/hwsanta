//
//  TheNavigationController.h
//  HopingForAWish
//
//  Created by Austin Chan on 11/25/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface TheNavigationController : UINavigationController

- (void)login;

- (void)nextAfterRegister;
- (void)nextAfterRules;
- (void)backBeforeRules;
- (void)nextAfterVerification;
- (void)nextAfterSelectPrep;
- (void)nextAfterSetupComplete;
- (void)selectUserID:(NSString *)userid;

- (void)shiftToTabs;

- (void)swipedUpToSignIn;
- (void)doneSetup;
@end
