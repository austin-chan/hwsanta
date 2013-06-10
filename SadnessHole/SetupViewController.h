//
//  SetupViewController.h
//  HopingForAWish
//
//  Created by Austin Chan on 11/25/12.
//  Copyright (c) 2012 Austin Chan. All rights reserved.
//

#import <UIKit/UIKit.h>

@interface SetupViewController : UIViewController <UITextFieldDelegate>

@property (weak, nonatomic) IBOutlet UITextField *firstNameField;
@property (weak, nonatomic) IBOutlet UITextField *lastNameField;
@property (weak, nonatomic) IBOutlet UILabel *topTitle;
@property (weak, nonatomic) IBOutlet UIButton *submitButton;
@property (weak, nonatomic) IBOutlet UIActivityIndicatorView *activityView;



- (IBAction)sophomoreSelected:(id)sender;
- (IBAction)juniorSelected:(id)sender;
- (IBAction)seniorSelected:(id)sender;

- (IBAction)maleSelected:(id)sender;
- (IBAction)femaleSelected:(id)sender;

- (IBAction)submitSelected:(id)sender;



@end
